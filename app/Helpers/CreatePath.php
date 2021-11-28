<?php

    class CreatePath{

        public static function createStoragePath($id){
            if(realpath(storage_path('app/public') . '/user_' . $id) == false){
                mkdir(storage_path('app/public') . '/user_' . $id, 0777);
                mkdir(storage_path('app/public') . '/user_' . $id . '/profile', 0777);
                mkdir(storage_path('app/public') . '/user_' . $id . '/book', 0777);
                mkdir(storage_path('app/public') . '/user_' . $id . '/book/front_cover', 0777);
                mkdir(storage_path('app/public') . '/user_' . $id . '/book/back_cover', 0777);
                mkdir(storage_path('app/public') . '/user_' . $id . '/book/inner_images', 0777);
            }
        }
    }

?>