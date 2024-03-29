<?php

namespace App\DataFixtures;

use App\Entity\Figure;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
   


        $categorie1 = new Categorie();
        $categorie1->setLibelle("Grabs")
                   ->setDescriptionCat("Un grab consiste à attraper la planche avec la main pendant le saut.");
        $manager->persist($categorie1);
        $categorie2 = new Categorie();
        $categorie2->setLibelle("Rotations")
                   ->setDescriptionCat("Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal.");
        $manager->persist($categorie2);
        $categorie3 = new Categorie();
        $categorie3->setLibelle("Slides")
                   ->setDescriptionCat("Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.");
        $manager->persist($categorie3);
        $categorie4 = new Categorie();
        $categorie4->setLibelle("Flips")
                   ->setDescriptionCat("Un flip est une rotation verticale.");
        $manager->persist($categorie4);

        $figure1 = new Figure();
        $figure1->setNom("Style week")
                ->setDescription("Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.")
                ->setImagetop("image1.jpg")
                ->setCategorie($categorie1)
                ->setSlug("styleweek");
        $manager->persist($figure1);
        $figure2 = new Figure();
        $figure2->setNom("Stalefish")
                ->setDescription("Saisie de la carre backside de la planche entre les deux pieds avec la main arrière ;")
                ->setImagetop("image2.jpg")
                ->setCategorie($categorie1)
                ->setSlug("stalefish");
        $manager->persist($figure2);
        $figure3 = new Figure();
        $figure3->setNom("Tail grab")
                ->setDescription("Saisie de la partie arrière de la planche, avec la main arrière.")
                ->setImagetop("image3.jpg")
                ->setCategorie($categorie1)
                ->setSlug("tail-grab");
        $manager->persist($figure3);
        $figure4 = new Figure();
        $figure4->setNom("Japan air")
                ->setDescription("Saisie de l'avant de la planche, avec la main avant, du côté de la carre frontside.")
                ->setImagetop("image4.jpg")
                ->setCategorie($categorie1)
                ->setSlug("japan-air");
        $manager->persist($figure4);

        $figure5 = new Figure();
        $figure5->setNom("Rotation frontside")
                ->setDescription("Une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.")
                ->setImagetop("image5.jpg")
                ->setCategorie($categorie2)
                ->setSlug("rotation-fronotside");
        $manager->persist($figure5);
        $figure6 = new Figure();
        $figure6->setNom("Rotation backside")
                ->setDescription("On désigne par le mot « rotation » uniquement des rotations horizontales.")
                ->setImagetop("image6.jpg")
                ->setCategorie($categorie2)
                ->setSlug("rotation-back-side");
        $manager->persist($figure6);
        $figure7 = new Figure();
        $figure7->setNom("Nose slide")
                ->setDescription("Avant de la planche sur la barre.")
                ->setImagetop("image7.jpg")
                ->setCategorie($categorie3);
        $manager->persist($figure7);
        $figure8 = new Figure();
        $figure8->setNom("Tail slide")
                ->setDescription("Arrière de la planche sur la barre.")
                ->setImagetop("image8.jpg")
                ->setCategorie($categorie3)
                ->setSlug("tail-side");
        $manager->persist($figure8);

        $figure9 = new Figure();
        $figure9->setNom("Front flip")
                ->setDescription("Un front flip est une rotation en avant.")
                ->setImagetop("image9.jpg")
                ->setCategorie($categorie4)
                ->setSlug("front-flip");
        $manager->persist($figure9);
        $figure10 = new Figure();
        $figure10->setNom("Back flip")
                ->setDescription("Un back flip est une rotation en arrière.")
                ->setImagetop("image10.jpg")
                ->setCategorie($categorie4)
                ->setSlug("back-flip");
        $manager->persist($figure10);

        $manager->flush();
    }
}
