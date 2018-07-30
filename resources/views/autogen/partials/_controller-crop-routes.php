Route::get('admin/{$FOLDER_NAME}/crop/url', array('as'=>'admin{$ROUTE_NAME}CropUrl','uses'=>'Admin\{$MODEL}Controller@crop_url'));
Route::get('admin/{$FOLDER_NAME}/{id}/crop/{column}/{asset_id}', array('as'=>'admin{$ROUTE_NAME}CropForm','uses'=>'Admin\{$MODEL}Controller@crop_form'));
Route::patch('admin/{$FOLDER_NAME}/{id}/crop', array('as'=>'admin{$ROUTE_NAME}Crop','uses'=>'Admin\{$MODEL}Controller@crop'));
