<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {

      //'Super', 'Manager', 'Valet', 'Customer'
      \App\User::insert([ 'name' => "Super", 'email' => "super@enviro.com", 'type' => 'Super', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png',]);

      \App\User::insert([ 'name' => "Manager", 'email' => "manager@enviro.com", 'type' => 'Manager', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png',]);

      \App\User::insert([ 'name' => "Valet", 'email' => "valet@enviro.com", 'type' => 'Valet', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png',]);

      \App\User::insert([ 'name' => "Customer", 'email' => "customer@enviro.com", 'type' => 'Customer', 'password' => Hash::make('1234567'), 'remember_token' => str_random(10), 'contact' => '', 'wage' => '', 'image' => 'img/noPicture.png',]);
      
      //DEFINE other seeds here or call other seeders e.g.
      //  factory(App\User::class, 1)->create();
      //  factory(App\User::class, 2)->create()->each(function($u) {});
      //  $this->call(UsersTableSeeder::class);
    }
}
