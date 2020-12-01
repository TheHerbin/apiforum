<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Message;



class AppFixtures extends Fixture
{
    private $manager;
    private $repoUser;
    private $faker;

    public function __construct(){
        $this->faker=Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $repoUser = $this->manager->getRepository(User::class);
        $this->loadUsers();
        $this->loadMessages();

        $manager->flush();

    }

    public function loadUsers(){
        for($i=0;$i<10;$i++){
            $user = new User();
            $user->setNom($this->faker->lastName())
            ->setPrenom($this->faker->firstName())
            ->setEmail($this->faker->email())
            ->setPassword(strtolower($user->getNom()))
            ->setDateInscription($this->faker->dateTimeThisYear);
            $this->addReference('user'.$i, $user);
            $this->manager->persist($user);
        }
        $user = new User();
        $user->setNom('LE GALES')
        ->setPrenom('julien')
        ->setEmail('julien.legales@gmail.com')
        ->setPassword('julien')
        ->setDateInscription(new \DateTime());
        $this->addReference('julien', $user);

        $this->manager->flush();

    }

    public function loadMessages(){
        for($i=0;$i<20;$i++){
            $message = new Message();
            $message->setTitre($this->faker->sentence());
            $message->setDatePoste($this->faker->dateTimeThisYear);
            $message->setCorps($this->faker->paragraph());
            $message->setUser($this->getReference('user'.mt_rand(0,9)));
            $this->addReference('message'.$i, $message);
            $this->manager->persist($message);
        }

        $message = new Message();
        $message->setTitre($this->faker->sentence());
        $message->setDatePoste($this->faker->dateTimeThisYear);
        $message->setCorps($this->faker->paragraph());
        $message->setUser($this->getReference('julien'));
        $this->manager->persist($message);

        for($i=0;$i<20;$i++){
            $message = new Message();
            $message->setTitre($this->faker->sentence());
            $message->setDatePoste($this->faker->dateTimeThisYear);
            $message->setCorps($this->faker->paragraph());
            $message->setUser($this->getReference('user'.mt_rand(0,9)));
            $message->setMessage($this->getReference('message'.mt_rand(0,19+$i)));
            $this->addReference('message'.(20+$i), $message);
            $this->manager->persist($message);

        }    

        $this->manager->flush();


    }
}
