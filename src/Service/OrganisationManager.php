<?php

namespace App\Service;

use Symfony\Component\Yaml\Yaml;

class OrganisationManager{
    public function getInfos($name = null){
        // Get infos in the yaml file containing infos
        // if no params, get all the organizations
        // if params, get only the params info (if organizations exists)
        // $name : name of the organization
        $file = Yaml::parseFile('files/organizations.yaml')["organizations"];
        if ($name != null){
            foreach ($file as $organization) {
                if ($organization["name"] == $name)
                    return $organization;
            }
            return null;
        }
        return $file;
    }

    public function updateInfo(){
        //TODO Update a line of the Yaml Organization file
        //return updated array (JSON) if success, or error
    }

    public function deleteInfo(){
        //Delete an Organization from the tab
    }

    public function addInfo(){
        //Add and Organization on the YAML file
    }
}