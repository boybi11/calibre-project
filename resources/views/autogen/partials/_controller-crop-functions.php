
    public function crop_url(Request $request)
    {
        $input = $request->all();
        $response = [
            'redirect'=>route('admin{$ROUTE_NAME}CropForm', [$input['id'], $input['column'], $input['asset_id']])
        ];

        return response()->json($response);
    }

    public function crop_form($id, $column, $asset_id)
    {
        $dimensions = ['width'=>300, 'height'=>300];

        return view('admin/{$FOLDER_NAME}/crop')
            ->with('title', 'Crop Image')
            ->with('data', {$MODEL}::findOrFail($id))
            ->with('column', $column)
            ->with('asset', Asset::findOrFail($asset_id))
            ->with('dimensions', $dimensions);
    }

    public function crop(Request $request, $id)
    {
        $input = $request->all();
        $asset = Asset::findOrFail($input['asset_id']);
        
        $filename = str_slug('{$SINGULAR_NAME}-' . $id . '-' . $input['column']);
        $image = Image::make($asset->path);
        $thumbnail = 'upload/thumbnails/' . $filename . '.' . $image->extension;
        $image->crop($input['crop_width'], $input['crop_height'], $input['x'], $input['y'])
            ->resize($input['target_width'], $input['target_height'])
            ->save($thumbnail, 100);

        $data = {$MODEL}::findOrFail($id);
        $data->$input['column'] = $thumbnail;
        $data->save();

        $log = 'crops ' . $input['column'] . ' of {$SINGULAR_NAME} "' . $data->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Crop successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('admin{$ROUTE_NAME}CropForm', [$data->id, $input['column'], $asset->id])
        ];

        return response()->json($response);
    }
