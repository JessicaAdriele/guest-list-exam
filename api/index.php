
<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'List/ListService.php';

$app = new \Slim\Slim();
/*
HTTP GET /api/guests
RESPONSE 200 OK 
[
  {
    "id": "1",
    "name": "Lidy Segura",
    "email": "lidyber@gmail.com"
  },
  {
    "id": "2",
    "name": "Edy Segura",
    "email": "edysegura@gmail.com"
  }
]
*/
$app->get('/guests/', function() use ( $app ) {
    $guests = TaskService::listTasks();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($guests);
});
/*
HTTP POST /api/guests
REQUEST Body 
{
	"name": "Lidy Segura",
	"email": "lidyber@gmail.com"
}

RESPONSE 200 OK 
{
  "name": "This is a test",
  "email": "test@gmail.com",
  "id": "1"
}
*/
$app->post('/guests/', function() use ( $app ) {
    $taskJson = $app->request()->getBody();
    $newTask = json_decode($taskJson, true);
    if($newTask) {
        $guests = TaskService::add($newTask);
        echo json_encode($guests);
        //echo "{$guests['id']},{$guests['name']}, {$guests['email']}";
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});


$app->delete('/guests/:id', function($id) use ( $app ) {
    if(TaskService::delete($id)) {
      echo "Task with id = $id was deleted";
    }
    else {
      $app->response->setStatus('404');
      echo "Task with id = $id not found";
    }
});


$app->run();
?>