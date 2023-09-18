<?php

namespace App\DataFixtures;

use App\Entity\Complexity;
use App\Entity\Country;
use App\Entity\Language;
use App\Entity\Organization;
use App\Entity\Priority;
use App\Entity\Relation;
use App\Entity\Role;
use App\Entity\TechnicalRole;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }
    public function load(ObjectManager $manager): void
    {
        $roles = ["administrateur", "commanditaire", "auditeur", "audite"];
        foreach ($roles as $r) {
            $role = new Role();
            $role->setName($r);
            $manager->persist($role);
        }
        $technicalRoles = ["ROLE_ADMIN", "ROLE_USER", "ROLE_INTERVIEW"];
        foreach ($technicalRoles as $tr) {
            $technicalRole = new TechnicalRole();
            $technicalRole->setName($tr);
            $manager->persist($technicalRole);
        }
        $languages = ["Arabe", "Anglais", "Francais"];
        foreach ($languages as $l) {
            $language = new Language();
            $language->setName($l);
            $manager->persist($language);
        }
        $countries = ["Maroc", "France", "Etas-unis"];
        foreach ($countries as $c) {
            $country = new Country();
            $country->setName($c);
            $manager->persist($country);
        }
        $complexities = ["Simple", "Modere", "Complexe", "Tres complexe"];
        foreach ($complexities as $c) {
            $complexity = new Complexity();
            $complexity->setName($c);
            $manager->persist($complexity);
        }
        $priorities = ["Basse", "Intermediaire", "Urgente"];
        foreach ($priorities as $p) {
            $priority = new Priority();
            $priority->setName($p);
            $manager->persist($priority);
        }
        $relations = ["Filiale", "Sous-traitant", "Client"];
        foreach ($relations as $r) {
            $relation = new Relation();
            $relation->setName($r);
            $manager->persist($relation);
        }
        $manager->flush();

        $organization = new Organization();
        $organization->setRelation($manager->getRepository(Relation::class)->findOneBy(['name' => 'Filiale']));
        $organization->setCountry($manager->getRepository(Country::class)->findOneBy(['name' => 'Etas-unis']));
        $organization->setName('Webaide');
        $manager->persist($organization);
        $manager->flush();

        $user = new User();
        $user->setOrganization($manager->getRepository(Organization::class)->findOneBy(['name' => 'Webaide']));
        $user->setFirstName("yahya");
        $user->setLastName("harakat");
        $user->setPhone("0612345678");
        $user->setAddress("120 aaa bbb ccc");
        $user->setFunction("najjar");
        $user->setHasInvitation(true);
        $user->setHasNotifications(false);
        $user->setLanguage($manager->getRepository(Language::class)->findOneBy(['name' => 'Anglais']));
        $user->setContactEmail("yahya@gmail.com");
        $user->setEmail("yahya@gmail.com");
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'yahya123'
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(["ROLE_ADMIN", "ROLE_USER", "administrateur"]);
        $roleObject = $manager->getRepository(Role::class)->findOneBy(['name' => "administrateur"]);
        $user->setRole($roleObject);
        $roles = ["ROLE_ADMIN", "ROLE_USER"];
        foreach ($roles as $role) {
            $roleObject = $manager->getRepository(TechnicalRole::class)->findOneBy(['name' => $role]);
            if ($roleObject !== null) {
                echo "Role found: " . $roleObject->getName() . "\n";
                $user->addTechnicalRole($roleObject);
            } else {
                echo "Role not found: " . $role . "\n";
            }
        }
        $manager->persist($user);
        $manager->flush();
    }
}
