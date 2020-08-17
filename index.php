<?php require 'vendor/autoload.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Countries!</title>
  </head>
  <body>
    
 
 
    <div class="container">
        <div class="row">
            <div class="col-5 jumbotron">
                <h1>Countries</h1>
                <div class="form-group">
                    <?php 
                        $client = new GuzzleHttp\Client();
                        $countries = $client->request('GET', 'https://restcountries.eu/rest/v2/all', []);

                        if($countries->getStatusCode()!==200){
                            echo "Error";
                        }else{
                        
                        }

                    ?>
                    <!-- <label for="exampleFormControlSelect1">Example select</label> -->
                    <select class="form-control" onchange="if (this.value) window.location.href=this.value">
                    <option>Select Country</option>
                    <?php
                        foreach(json_decode($countries->getBody(), TRUE) as $data){
                            if(isset($_GET['val'])===true){
                                if($_GET['val']===$data['name']){
                                    echo '<option value="?val='.$data['name'].'" selected>'.$data['name'].'</option>' ;
                                }else{
                                  echo '<option value="?val='.$data['name'].'">'.$data['name'].'</option>' ;  
                                }
                                    
                            }else{
                                  echo '<option value="?val='.$data['name'].'">'.$data['name'].'</option>' ;  
                            }
                             
                        
                             
                        }
                    ?>
                    </select>
                </div>
            </div>
            <div class="col-2"></div>
            <div class="col-5 jumbotron">
                <h1>Country Borders</h1>
                <ul class="list-group">
                <?php

                    if(isset($_GET['val'])===true){
                        $client = new GuzzleHttp\Client();
                        $borders = $client->request('GET', 'https://restcountries.eu/rest/v2/name/'.$_GET['val'], []);

                        if($borders->getStatusCode()!==200){
                            echo "Error";
                        }else{
                            echo count(json_decode($borders->getBody(), TRUE)[0]['borders'])>0 ? '': $_GET['val'].' have no border countries';
                     
                            $my_border = '';
                            foreach(json_decode($borders->getBody(), TRUE)[0]['borders'] as $data){
                                $my_border = $my_border.''.$data.';';
                               
                            }

                            if(count(json_decode($borders->getBody(), TRUE)[0]['borders']>0)){
                                $client = new GuzzleHttp\Client();
                                $my_country = $client->request('GET', 'https://restcountries.eu/rest/v2/alpha?codes='.$my_border, []);
                                foreach(json_decode($my_country->getBody(), TRUE) as $data){
                                
                                    echo '<li class="list-group-item">'.$data['name'].'</li>';
                                }
                            }
                        }
                    }
                ?>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>

