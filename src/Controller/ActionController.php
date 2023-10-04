<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\Complexity;
use App\Entity\Organization;
use App\Entity\Priority;
use App\Entity\Status;
use App\Entity\User;
use App\Repository\ActionRepository;
use App\Repository\ComplexityRepository;
use App\Repository\PriorityRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api')]
class ActionController extends AbstractController

{
    private $entityManager;
    private $validator;
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        private ActionRepository $actionRepo,
        private ComplexityRepository $complexityRepo,
        private PriorityRepository $priorityRepo,
        private UserRepository $userRepo,
        private StatusRepository $statusRepo
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    #[Route('/actions/actions-current-organization', name: "actions_current_organization", methods: ["get"])]
    public function actionsByOrganization(#[CurrentUser()] ?User $user): Response
    {
        $actions = $user
            ->getOrganization()
            ->getActions();

        $normalized = array();

        foreach ($actions as $action) {
            $normalized[] = [
                "id" => $action->getId(),
                "title" => $action->getTitle(),
            ];
        }

        return $this->json($normalized);
    }

    #[Route('/actions', name: "actions.store", methods: ["post"])]
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    public function store(Request $request, #[CurrentUser()] ?User $currentUser)
    {
        $decoded = json_decode($request->getContent());
        // return $this->json($decoded);
        $storeAction = function (object $user) use ($decoded, $currentUser) {
            $action = new Action();
            // $decoded->id !== null && $action->setId($decoded->id);
            $action->setOrganization($currentUser->getOrganization());
            $action->setTitle($decoded->title);
            $action->setComplexity($this->complexityRepo->find($decoded->complexity));
            $action->setPriority($this->priorityRepo->find($decoded->priority));
            $action->setDescription($decoded->description);
            $action->setStatus($this->statusRepo->find(1));
            $action->setIsReccurent($decoded->isReccurent);
            $action->setStartAt(Carbon::parse($decoded->startAt)->toImmutable());
            $action->setDueAt(Carbon::parse($decoded->dueAt)->toImmutable());
            $action->setUser($user);
            return $action;
        };
        // if (!$decoded->id) {
        $getUsersByRole = function ($users, $role) {
            $usersWithRole = array();
            foreach ($users as $user) {
                if (in_array($role, $user->getRoles())) {
                    if (in_array($role, $user->getRoles())) {
                        $usersWithRole[] = $user;
                    }
                }
            }
            return $usersWithRole;
        };

        $assignUsers = array();
        if ($decoded->assign->user) {
            $assignUsers[] = $this->userRepo->find($decoded->assign->user);
            // return $this->json($assignUsers[0]->getEmail());
        } else if ($decoded->assign->role) {
            $assignRole = $decoded->assign->role;
            if ($decoded->assign->organization) {
                // assign the action to the users who belongs to this organization and have this role 
                $users = $this->userRepo->findByOrganization($this->entityManager->getRepository(Organization::class)->find($decoded->assign->organization));
                $assignUsers = $getUsersByRole($users, $assignRole);
            } else {
                $users = $this->userRepo->findAll();
                $assignUsers = $getUsersByRole($users, $assignRole);
            }
        } else {
            $assignUsers = $this->userRepo->findByOrganization($this->entityManager->getRepository(Organization::class)->find($decoded->assign->organization));
            // return $this->json(["message" => "ya hala"]);
        }

        if (count($assignUsers) > 0) {
            $errors = $this->validator->validate($storeAction($assignUsers[0]));

            if (count($errors) > 0) {
                return $this->json($errors);
            }
            $this->entityManager->beginTransaction();
            try {
                // Persist the entity
                foreach ($assignUsers as $assignUser) {
                    $this->entityManager->persist($storeAction($assignUser));
                    $this->entityManager->flush();
                }
                // Commit the transaction
                $this->entityManager->commit();
                return $this->json(['message' => 'action has been created successfully'], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                // Rollback the transaction on error
                $this->entityManager->rollback();

                return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return $this->json(["message" => "You need to assign the action to an entity"]);
        }
        // } else {
        //     $this->entityManager->persist($storeAction($assignUser));
        //     $this->entityManager->flush();
        // }
    }

    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    #[Route('/actions/{id}', methods: ["DELETE"])]
    function delete(?string $id, #[CurrentUser()] ?User $user)
    {
        $action = $this->actionRepo->find($id);
        $name = $action->getTitle();
        $actionId = $action->getId();
        $myActions = $user->getOrganization()->getActions();
        if ($myActions->contains($action)) {
            $this->entityManager->remove($action);
            $this->entityManager->flush();
            return $this->json([
                "message" => "the action with the title " . $name . " has been deleted",
                "id" => $actionId
            ], status: 200);
        } else {
            return $this->json(["message" => "authorized to delete only your actions"], status: 401);
        }
    }
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    #[Route('/actions/{id}', methods: ["PATCH", "PUT"])]
    function update(Request $request, ?string $id, #[CurrentUser()] ?User $currentUser)
    {
        $action = $this->actionRepo->find($id);
        $actionId = $action->getId();
        $myActions = $currentUser->getOrganization()->getActions();
        if ($myActions->contains($action)) {
            $decoded = json_decode($request->getContent());
            $updatedAction = $this->actionRepo->find($id);
            $updatedAction->setTitle($decoded->title);
            $updatedAction->setComplexity($this->complexityRepo->find($decoded->complexity));
            $updatedAction->setPriority($this->priorityRepo->find($decoded->priority));
            $updatedAction->setDescription($decoded->description);
            $updatedAction->setStartAt(Carbon::parse($decoded->startAt)->toImmutable());
            $updatedAction->setDueAt(Carbon::parse($decoded->dueAt)->toImmutable());
            $updatedAction->setIsReccurent($decoded->isReccurent);
            $updatedAction->setInterval($decoded->interval);
            $this->entityManager->persist($updatedAction);
            $this->entityManager->flush();
            return $this->json([
                "message" => "the action with the title " . $action->getTitle() . " has been updated",
                "id" => $actionId
            ], status: 200);
        } else {
            return $this->json(["message" => "authorized to update only your actions"], status: 401);
        }

        // $deleteResponse = $this->delete($id, $currentUser);
        // if ($deleteResponse->getStatusCode() == "200") {
        //     $requestContent = json_encode(array_merge(
        //         json_decode($request->getContent(), true),
        //         ['id' => json_decode($deleteResponse->getContent(), true)['id']]
        //     ));
        //     $req = new Request(content: $requestContent);
        //     // return new Response($requestContent);
        //     $res = $this->store($req, $currentUser);
        //     return $this->json(json_decode($res->getContent()));
        // }
    }

    #[Route('/actions/{actionId}/status/{statusId}', methods: ["PATCH", "PUT"])]
    function updateStatus($actionId, $statusId, #[CurrentUser()] ?User $currentUser)
    {
        $action = $this->actionRepo->find($actionId);
        $status = $this->statusRepo->find($statusId);
        $adminHasAccess = $this->isGranted('ROLE_ADMIN');
        $userHasAccess = $this->isGranted('ROLE_USER');
        $myActions = array();
        if ($adminHasAccess) {
            $myActions = $currentUser->getOrganization()->getActions();
        } else if ($userHasAccess) {
            $myActions = $currentUser->getActions();
        }
        if ($myActions->contains($action)) {
            $action->setStatus($status);
            $this->entityManager->persist($action);
            $this->entityManager->flush();
            return $this->json([
                "message" => "the action with the title " . $action->getTitle() . " has been updated",
                "id" => $actionId
            ], status: 200);
        } else {
            return $this->json(["message" => "authorized to update only your actions"], status: 401);
        }
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/actions/my-organization', name: "actions-my-organization", methods: ["GET"])]
    public function actionsMyOraganization(#[CurrentUser()] ?User $user): Response
    {
        $conn = $this->entityManager->getConnection();
        $actionsMyOraganization = $conn->executeQuery(
            'SELECT a.* from action a inner join user u on a.user_id = u.id where u.organization_id = :organizationId',
            ['organizationId' => $user->getOrganization()->getId()]
        )
            ->fetchAllAssociative();
        return $this->json($actionsMyOraganization);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/actions/check-periodicity', name: "check_periodicity", methods: ["get"])]
    public function checkPeriodicity(#[CurrentUser()] ?User $user): Response
    {
        $actionsMyOraganization = json_decode($this->actionsMyOraganization($user)->getContent(), true);
        foreach ($actionsMyOraganization as $actionMyOrganization) {
            if ($actionMyOrganization['is_reccurent'] == 1) {
                // return $this->json('1');
                $date = Carbon::createFromTimeString($actionMyOrganization['next_updated_at']);
                $now = Carbon::now();
                if ($date->diffInDays($now, false) >= 0) {
                    $action = $this->actionRepo->find($actionMyOrganization['id']);
                    $action->setNextUpdatedAt(Carbon::createFromImmutable($action->getNextUpdatedAt())->addDays($action->getInterval())->toImmutable());
                    $newAction = new Action();
                    $newAction->setTitle($action->getTitle());
                    $newAction->setComplexity($action->getComplexity());
                    $newAction->setPriority($action->getPriority());
                    $newAction->setOrganization($action->getOrganization());
                    $newAction->setUser($action->getUser());
                    $newAction->setDescription($action->getDescription());
                    $newAction->setStartAt(Carbon::createFromImmutable($action->getStartAt())->addDays($action->getInterval())->toImmutable());
                    $newAction->setDueAt(Carbon::createFromImmutable($action->getDueAt())->addDays($action->getInterval())->toImmutable());
                    $newAction->setReference($action->getReference());
                    $newAction->setStatus($action->getStatus());
                    $newAction->setIsReccurent(false);
                    $this->entityManager->persist($action);
                    $this->entityManager->persist($newAction);
                    $this->entityManager->flush();
                    return $this->json('2');
                }
            }
        }

        return $this->json("3");
        // return $this->json($date->diffInDays($now, false));
    }
}
