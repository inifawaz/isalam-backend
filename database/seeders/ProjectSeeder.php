<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectUpdate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create(
            [
                'user_id' => 1,
                'category_id' => 1,
                "location" => 'Karanganyar',
                'name' => "Pengadaan Mushaf Al Qur'an Untuk PPTQ Al Qolam Karanganyar",
                "picture_url" => "wakaf-mushaf.jpeg",

                'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer sodales sed est eget condimentum. Etiam varius, tortor viverra tristique pharetra, magna sapien venenatis odio, non aliquam erat odio ac nibh. Nulla dictum, lacus at pharetra mattis, ex diam hendrerit nibh, maximus tincidunt dolor nisi vel justo. Vivamus ornare diam sed dolor dictum, id sodales orci tempus. Aenean consectetur rhoncus sapien quis vulputate. Maecenas et tempus neque, eget tincidunt odio. Sed pretium lobortis rhoncus. Phasellus ultrices, orci a semper bibendum, nibh ipsum rutrum risus, vel elementum tellus tellus a ante.

                Pellentesque a tempor ex. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce felis lacus, dignissim et libero eget, dictum commodo tortor. Donec nec tempor velit. Suspendisse finibus ligula eu efficitur ullamcorper. Pellentesque vel nibh nec sem malesuada lacinia elementum et lectus. Vivamus malesuada faucibus nibh quis tincidunt. Etiam dapibus risus mollis, porttitor elit molestie, posuere justo. Quisque ex sem, cursus ut pretium ac, condimentum eu quam. Donec mi nunc, gravida at diam a, ultrices elementum ex.

                Nam porttitor leo tempus tempus maximus. Phasellus nec finibus nibh. Vivamus pellentesque purus lectus, eget tempor dolor accumsan at. Mauris consequat fermentum ante, vel suscipit enim condimentum eget. Nam et magna enim. Aliquam erat volutpat. Morbi ornare sed nulla quis iaculis. Praesent pellentesque eros a urna dictum pretium. Nulla quis lacus id lacus molestie posuere vitae quis sem. Sed est lorem, luctus eget dictum ac, ullamcorper eu leo. Nunc velit elit, elementum a metus id, ornare hendrerit sapien. Morbi in nisi id est consectetur auctor. Sed dapibus et libero sed pulvinar. In vel diam non orci pulvinar fermentum. Praesent vestibulum, ex a dictum congue, odio leo hendrerit magna, vel lobortis massa nisl nec magna.

                Integer auctor nunc dui, tincidunt sollicitudin turpis rutrum ut. Aenean nec augue ut justo consectetur molestie vitae non nisl. Aliquam id ornare magna. Morbi id ante eu erat scelerisque faucibus a vitae turpis. Cras egestas, ipsum quis auctor pharetra, dui neque tincidunt odio, non viverra mi nunc venenatis ligula. Phasellus posuere dui purus, vitae imperdiet massa ultricies non. Praesent iaculis tincidunt condimentum. Donec eget turpis in risus semper pellentesque in sit amet ligula. Aenean ac dapibus magna. Suspendisse laoreet ut magna eu molestie. Praesent vitae ex et orci gravida tincidunt. Maecenas viverra, magna a convallis fermentum, turpis leo consequat orci, sed euismod diam erat eu felis. In faucibus volutpat venenatis. Vivamus tincidunt ex nec neque volutpat dapibus. Aliquam ullamcorper lobortis massa id cursus.

                Curabitur tempor augue eget ipsum ornare lobortis. Pellentesque eget auctor nunc, sit amet pharetra sem. In interdum efficitur ante eu faucibus. Vestibulum sit amet sem vel magna cursus rutrum fermentum non purus. Cras vitae leo malesuada, vestibulum nisi quis, congue ante. Nam in metus ex. Curabitur scelerisque ipsum nisl, eu bibendum ligula convallis non.",
                "start_date" => '2022-08-03',
                "end_date" => "2022-09-10",
                "maintenance_fee" => 5000,
                "target_amount" => 10000000,
                "first_choice_amount" => 50000,
                "second_choice_amount" => 100000,
                "third_choice_amount" => 150000,
                "fourth_choice_amount" => 200000
            ]
        );

        ProjectUpdate::create(
            [
                "user_id" => 1,
                "project_id" => 1,
                "text" => "Curabitur tempor augue eget ipsum ornare lobortis. Pellentesque eget auctor nunc, sit amet pharetra sem. In interdum efficitur ante eu faucibus.",
                "date" => "2022-09-01"
            ]
        );

        ProjectUpdate::create(
            [
                "user_id" => 1,
                "project_id" => 1,
                "text" => "Cras vitae leo malesuada, vestibulum nisi quis, congue ante. Nam in metus ex. Curabitur scelerisque ipsum nisl, eu bibendum ligula convallis non.",
                "date" => "2022-09-08"
            ]
        );
        ProjectUpdate::create(
            [
                "user_id" => 1,
                "project_id" => 1,
                "text" => "Donec eget turpis in risus semper pellentesque in sit amet ligula. Aenean ac dapibus magna. Suspendisse laoreet ut magna eu molestie.",
                "date" => "2022-09-12"
            ]
        );
    }
}
