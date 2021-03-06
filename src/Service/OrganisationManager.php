<?php

namespace App\Service;

use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Component\Yaml\Yaml;

class OrganisationManager
{
    public function getOrganizations($name = null)
    {
        // Get infos in the yaml file containing infos
        // if no params, get all the organizations
        // if params, get only the params info (if organizations exists)
        // $name : name of the organization
        $file = Yaml::parseFile('files/organizations.yaml')["organizations"];
        if ($name != null) {
            foreach ($file as $organization) {
                if ($organization["name"] == $name)
                    return $organization;
            }
            return null;
        }
        return $file;
    }

    public function updateOrganizations($informations)
    {
        //Update a line of the Yaml Organization file
        //return organization name
        $informations["users"] = json_decode($informations["users"]);

        $proceededInformations = [];
        $proceededInformations["name"] = $informations["organizationName"];
        $proceededInformations["description"] = $informations["organizationDescription"];
        $proceededInformations["users"] = [];

        for ($i = 0; $i < count($informations["users"]); $i++) {
            $proceededInformations["users"][$i] = get_object_vars($informations["users"][$i]);
        }
        $file = $this->getOrganizations();

        for ($i = 0; $i < count($file); $i++) {
            if ($file[$i]["name"] == $proceededInformations["name"]) {
                $file[$i] = $proceededInformations;
                $yaml = Yaml::dump(["organizations" => $file], 2); //Trying to get the expanded array version but doesnt seems to work (function doesnt seems to work)
                file_put_contents('files/organizations.yaml', $yaml);
                return 'UPDATED';
            }
        }
        $file[] = $proceededInformations;
        $yaml = Yaml::dump(["organizations" => $file], 2);
        file_put_contents('files/organizations.yaml', $yaml);
        return 'CREATED';
    }

    public function deleteOrganization($organizationName)
    {
        //Delete an Organization from the tab

        $file = $this->getOrganizations();
        for ($i = 0; $i < count($file); $i++){
            if ($file[$i]["name"] == $organizationName){
                array_splice($file, $i, 1);
                $yaml = Yaml::dump(["organizations" => $file], 2);
                file_put_contents('files/organizations.yaml', $yaml);
                return true;
            }
        }
        return false;
    }

}
