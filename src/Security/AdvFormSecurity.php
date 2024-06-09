<?php
namespace App\Security;
use App\Entity\Advertisement;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdvFormSecurity {

    // CHECKFORM USERPROFILE
    public function checkFormUser(User $inputs, UserPasswordHasherInterface $userPasswordHasher)
    {

        // vérification des inputs pour l'ajout d'une annonce
        
        $pseudo = $inputs->getPseudo();
        $email= $inputs->getEmail();
        // $password = $inputs->getPassword();
        $city = $inputs->getCity();
        $level = $inputs->getLevel();
        $isAlone = $inputs->isIsAlone();
        $instrument = $inputs->getInstrument();
        $styleMusic = $inputs->getStyleMusic();
        $description = $inputs->getDescription();
        
        if(isset($pseudo) && isset($email) && isset($isAlone) 
            && !empty($pseudo) && !empty($email) && is_bool($isAlone)){ 
                
            $inputs->setPseudo(strip_tags($pseudo));
            $inputs->setEmail(strip_tags($email));
            // $inputs->setPassword($userPasswordHasher->hashPassword($inputs,(strip_tags($password))));
            $inputs->setCity(strip_tags($city));
            $inputs->setLevel(strip_tags($level));
            $inputs->setIsAlone(strip_tags($isAlone));
            $inputs->setInstrument(strip_tags($instrument));
            $inputs->setStyleMusic(strip_tags($styleMusic));
            $inputs->setDescription(strip_tags($description));

            $validForm = true;

        } else {
            $validForm = false;
        }

        // traiter les inputs en fonction des villes/musiciens existants dans les fichier json 

        // $advCity = strtoupper($city);
        // $advMusician = strtolower($lookingFor);

        // $cities = json_decode(file_get_contents("datas/city.json"));
        // $musicians = json_decode(file_get_contents("datas/musicians.json"));

        // if(!in_array($advCity, $cities) || !in_array($advMusician, $musicians)){
        //     $validForm = false;
        // }

           
        return !$validForm ? false : $inputs;

    }

    // CHECKFORM ADVERTISEMENT
    public function checkForm(Advertisement $inputs)
    {

        // vérification des inputs pour l'ajout d'une annonce

        $title = $inputs->getTitle();
        $lookingFor = $inputs->getLookingFor();
        $city = $inputs->getCity();
        $description = $inputs->getDescription();
        if(isset($title) && isset($lookingFor) && isset($city) && isset($description)
            && !empty($title) && !empty($lookingFor) && !empty($city) && !empty($description)){ //à vérifier

            $inputs->setTitle(strip_tags($title));
            $inputs->setCity(strip_tags($city));
            $inputs->setLookingFor(strip_tags($lookingFor));
            $inputs->setDescription(strip_tags($description));

            $validForm = true;

        } else {
            $validForm = false;
        }

        // traiter les inputs en fonction des villes/musiciens existants dans les fichier json 

        $advCity = strtoupper($city);
        $advMusician = strtolower($lookingFor);

        $cities = json_decode(file_get_contents("datas/city.json"));
        $musicians = json_decode(file_get_contents("datas/musicians.json"));
        array_unshift($musicians, "groupe");


        if(!in_array($advCity, $cities) || !in_array($advMusician, $musicians)){
            $validForm = false;
        }

        return !$validForm ? $validForm : $inputs;

    }

    public function getRegion(string $city): string
    {
        $regions = json_decode(file_get_contents("../public/datas/regions.json"));

        for($i = 0; $i < count($regions); $i++){
            if($regions[$i]->Nom_commune == $city){
                return $regions[$i]->Code_postal;
            }
        }
    }
}

