<?php

namespace library;

use Exception;
use Google\Client;
use Google\Service\Drive;

class  DriveModel{
    private $driveService;
    protected $credential = __DIR__.'/credential.json';
    protected $folderId = '1TuKxVo-ee2T-eZLwU6O80FspGVyRUInQ';

    public function __construct(){
        $client = new Client();
        $client->setAuthConfig($this->credential);
        $client->addScope(Drive::DRIVE);
        $client->setAccessType('offline');
        $this->driveService= new Drive($client);
    }

    // get list isi drive
    public function getList(){
        try{
            $files=[];
            $pageToken = null;
            do{
                $response = $this->driveService->files->listFiles([
                    'q' => "'".$this->folderId."' in parents",
                    'spaces' => 'drive',
                    'corpora'=>'user',
                    'pageToken' => $pageToken,
                    'fields' => 'nextPageToken, files(id,name)'
                ]);
                foreach($response->files as $file){
                    array_push($files,[
                        'name'=>$file->name,
                        'id'=>$file->id,
                        'parents'=>$file->parents,
                    ]);
                }
            }
            while($pageToken!=null);
            return $files;
        }
        catch(Exception $err){
            echo "error : $err";
            return null;
        }
    }
}