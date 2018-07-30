<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;

use App\Http\Requests;

class AutogenController extends Controller
{
  private $dir = '../resources/views/autogen/';
  private $ignored_columns = ['id', 'created_at', 'updated_at', 'deleted_at'];

  public function index()
  {
    // get tables from database
    $tables = [];
    $table_list = DB::select('SHOW TABLES');
    foreach ($table_list as $table) {
      foreach ($table as $key => $value) {
        $tables[] = $value;
      }
    }
    $tables = collect($tables);

    // get ignored tables from .env file
    $ignored_tables = collect(explode(',', env('SUMOGEN_IGNORED_TABLES')));
    $pivot_tables = env('SUMOGEN_PIVOT_TABLES');
    if (! is_null($pivot_tables)) {
      $ignored_tables = $ignored_tables->merge(explode(',', $pivot_tables));
    }
    $ignored_tables = $ignored_tables->toArray();

    // exclude ignored tables
    $tables = $tables->filter(function ($value, $key) use ($ignored_tables) {
      return !in_array($value, $ignored_tables);
    });
    $tables = $tables->toArray();

    // get info from tables
    $tables_with_columns = [];
    if (! empty($tables)) {
      foreach ($tables as $table) {
        $columns = DB::select(DB::raw('SHOW FIELDS FROM ' . $table));
        $all_columns = [];
        $fillable_columns = [];
        $fillable_column_names = [];
        $fillable_column_rules = [];
        $asset_columns = [];
        foreach ($columns as $column) {
          $details = [];
          $details['field'] = $column->Field;
          $details['type'] = $column->Type;
          $details['null'] = $column->Null;
          if (! in_array($column->Field, $this->ignored_columns)) {
            $fillable_columns[] = $details;
            $fillable_column_names[] = $column->Field;

            // set rules
            $rules = $this->_rules($details);
            $fillable_column_rules[$column->Field] = $rules;

            // get croppable columns
            if ($thumb_pos = strpos($column->Field, '_thumbnail')) {
              $asset_columns[] = substr($column->Field, 0, $thumb_pos);
            }
          }
          $all_columns[] = $details;
        }

        // print_r($asset_columns); 
        // die();
        // dd($columns);
        // dd($fillable_column_rules);

        // // generate model
        // $generate_model = $this->_model($table, $fillable_column_names);
        // if ($generate_model) {
        //   echo 'model created';
        // } else {
        //   echo 'model duplicate';
        // }
        // generate controller
        $generate_controller = $this->_controller($table, $fillable_column_names, $asset_columns);
        if ($generate_controller) {
          echo 'contoller created';
        } else {
          echo 'contoller duplicate';
        }
        // // generate request
        // $generate_request = $this->_request($table, $fillable_column_rules);
        // if ($generate_request) {
        //   echo 'request created';
        // } else {
        //   echo 'request duplicate';
        // }
        // // generate views
        // $generate_index_view = $this->_view_index($table, $fillable_column_names);
        // if ($generate_index_view) {
        //   echo 'index views created';
        // } else {
        //   echo 'index views duplicate';
        // }
        // $generate_create_view = $this->_view_create($table);
        // if ($generate_create_view) {
        //   echo 'create views created';
        // } else {
        //   echo 'create views duplicate';
        // }
        // $generate_edit_view = $this->_view_edit($table);
        // if ($generate_edit_view) {
        //   echo 'edit views created';
        // } else {
        //   echo 'edit views duplicate';
        // }
        // $generate_form_view = $this->_view_form($table, $fillable_columns, $asset_columns);
        // if ($generate_form_view) {
        //   echo 'form views created';
        // } else {
        //   echo 'form views duplicate';
        // }
        // if (! empty($asset_columns)) {
        //   $generate_crop_view = $this->_view_crop($table);
        //   if ($generate_form_view) {
        //     echo 'crop views created';
        //   } else {
        //     echo 'crop views duplicate';
        //   }
        // }

        // $this->_view_show($table, $fillable_columns, $asset_columns);
        // $this->_view_view($table, $all_columns, $fillable_columns, $asset_columns);
        
        // dd($fillable_column_names);
        // dd($fillable_columns);
        // dd($tables_with_columns);
      }
    } else {
      // end command - no files generated
    }
  }

  private function _rules($details)
  {
    $rules = '';
    $type = (stripos($details['type'], '(')) ? substr($details['type'], 0, stripos($details['type'], '(')) : $details['type'];

    if ($details['null'] == 'NO') {
      $rules = $this->_add_pipe($rules);
      $rules .= 'required';
    }
    if ($type == 'varchar') {
      $max = substr($details['type'], stripos($details['type'], '(') + 1, stripos($details['type'], ')') - stripos($details['type'], '(') - 1);
      $rules = $this->_add_pipe($rules);
      $rules .= 'max:' . $max;
    }
    if ($type == 'enum') {
      $options = substr($details['type'], stripos($details['type'], '(') + 1, stripos($details['type'], ')') - stripos($details['type'], '(') - 1);
      $options = str_replace("'", "", $options);
      $rules = $this->_add_pipe($rules);
      $rules .= 'in:' . $options;
    }
    if ($type == 'int') {
      $rules = $this->_add_pipe($rules);
      $rules .= 'integer';
    }

    return $rules;
  }

  private function _add_pipe($rules)
  {
    if ($rules != '') {
      $rules .= '|';
    }

    return $rules;
  }

  /**
   * [generate controller file]
   * @param  [string] $table_name       [name of table]
   * @param  [string] $name_column      [name or column after table id]
   * @param  [array] $fillable_columns  [looping of columns when saving]
   * @return [bool]                     [if file creation is TRUE or FALSE]
   */
  private function _controller($table_name, $fillable_column_names, $asset_columns)
  {
  	$file = '../app/Http/Controllers/Admin/TestController.php';
  	if (! file_exists($file))
  	{
      $name_column = $fillable_column_names[0];
  		$content = file_get_contents($this->dir . 'controller.php');

  		$model = ucfirst(str_singular($table_name));
  		$content = str_replace('{$MODEL}', $model, $content);

  		$content = str_replace('{$NAME_COLUMN}', $name_column, $content);

  		$folder_name = $table_name;
  		$content = str_replace('{$FOLDER_NAME}', $folder_name, $content);

  		$route_name = ucfirst($table_name);
  		$content = str_replace('{$ROUTE_NAME}', $route_name, $content);

  		$singular_name = str_singular($table_name);
  		$content = str_replace('{$SINGULAR_NAME}', $singular_name, $content);

      if (in_array('slug', $fillable_column_names)) {
        
      }

      $crop_imports = '';
      $crop_functions = '';
      $crop_routes = '';
      if (! empty($asset_columns)) {
        $crop_imports = file_get_contents($this->dir . '/partials/_controller-crop-imports.php');
        
        $crop_functions = file_get_contents($this->dir . '/partials/_controller-crop-functions.php');
        $crop_functions = str_replace('{$MODEL}', $model, $crop_functions);
        $crop_functions = str_replace('{$ROUTE_NAME}', $route_name, $crop_functions);
        $crop_functions = str_replace('{$FOLDER_NAME}', $folder_name, $crop_functions);
        $crop_functions = str_replace('{$SINGULAR_NAME}', $singular_name, $crop_functions);

        $crop_routes = file_get_contents($this->dir . '/partials/_controller-crop-routes.php');
        $crop_routes = str_replace('{$MODEL}', $model, $crop_routes);
        $crop_routes = str_replace('{$ROUTE_NAME}', $route_name, $crop_routes);
        $crop_routes = str_replace('{$FOLDER_NAME}', $folder_name, $crop_routes);
      }
      $content = str_replace('{$CROP_IMPORTS}', $crop_imports, $content);
      $content = str_replace('{$CROP_FUNCTIONS}', $crop_functions, $content);
      $content = str_replace('{$CROP_ROUTES}', $crop_routes, $content);

  		file_put_contents($file, $content);

      return true;
  	} 
    else 
    {
      return false;
    }
  }

  /**
   * [generate model file]
   * @param  [string] $table_name       [name of table]
   * @param  [array] $fillable_columns  [added to eloquent variable - fillable columns]
   * @param  [bool] $soft_delete        [if soft delete is implemented or not]
   * @return [bool]                     [if file creation is TRUE or FALSE]
   */
  private function _model($table_name, $fillable_columns, $soft_delete = false)
  {
    $file = '../app/Test.php';

    if (! file_exists($file))
    {
      $content = file_get_contents($this->dir . 'model.php');

      // adding image partial
      $partial_image = '';
      if (in_array('image', $fillable_columns)) {
        $partial_image = "\n\r " . file_get_contents($this->dir . '/partials/_model-has-image.php');
      }
      $content = str_replace('{$HAS_IMAGE}', $partial_image, $content);

      // adding columns and date fillables
      $dates = '';
      $columns = '';
      $i = 1;
      foreach ($fillable_columns as $f) {
        if ($i > 1) {
            $columns .=   "        ";
        }
        $columns .= "'{$f}',";
        if ($i < count($fillable_columns)) {
            $columns .= "\n\r";
        }
        $i++;

        if (strpos($f, '_at')) {
            $dates .= "'{$f}', ";
        }
      }
      $content = str_replace('{$COLUMNS}', $columns, $content);
      if ($dates != '') {
        $partial_dates = "\n\r " . file_get_contents($this->dir . '/partials/_model-protected-dates.php') . "\n\r";
      } else {
        $partial_dates = "";
      }
      $content = str_replace('{$DATES}', $partial_dates, $content);
      $content = str_replace('{$DATE_COLUMNS}', $dates, $content);

      // soft deletion
      $soft_delete_inject = '';
      $soft_delete_use = '';
      if ($soft_delete) {
        $soft_delete_inject = "\n\ruse Illuminate\Database\Eloquent\SoftDeletes;";
        $soft_delete_use = "\n\r    use SoftDeletes;\n\r";
      }
      $content = str_replace('{$SOFT_DELETE_INJECT}', $soft_delete_inject, $content);
      $content = str_replace('{$SOFT_DELETE_USE}', $soft_delete_use, $content);

      // declaring model name
      $model = ucfirst(str_singular($table_name));
      $content = str_replace('{$MODEL}', $model, $content);

      file_put_contents($file, $content);

      return true;
    } 
    else 
    {
      return false;
    }
  }

  /**
   * generate request file
   * @param  [string] $table_name       [name of table]
   * @param  [array] $fillable_columns  [columns of table, used for validation rules]
   * @return [bool]                     [if file creation is TRUE or FALSE]
   */
  private function _request($table_name, $fillable_columns)
  {
    $file = '../app/Http/Requests/TestRequest.php';
    if (! file_exists($file))
    {
      $content = file_get_contents($this->dir . 'request.php');

      $model = ucfirst(str_singular($table_name));
      $content = str_replace('{$MODEL}', $model, $content);

      // rules
      $rules = '';
      $i = 1;
      foreach ($fillable_columns as $column => $rule) {
        if ($i > 1) {
          $rules .=   "            ";
        }
        $rules .=   "'{$column}' => '{$rule}',";
        if ($i < count($fillable_columns)) {
          $rules .= "\n\r";
        }
        $i++;
      }
      $content = str_replace('{$RULES}', $rules, $content);

      file_put_contents($file, $content);

      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * generate index view
   * @param  [string] $table_name             [name of table]
   * @param  [array]  $fillable_columns_names [names of table columns]
   * @return [bool]                           [if file creation is TRUE or FALSE]
   */
  private function _view_index($table_name, $fillable_columns_names)
  {
    // create folder if not exist
    $folder = '../resources/views/admin/' . $table_name;
    if (! is_dir($folder)) {
      mkdir($folder);
    }

    $collection = collect($fillable_columns_names);
    $title = ucfirst($table_name);
    $route = ucfirst($table_name);
    $singular_name = str_singular($table_name);

    $file = $folder . '/index.blade.php';
    if (! file_exists($file))
    {
      $content = file_get_contents($this->dir . 'views/index.blade.php');

      $content = str_replace('{$TITLE}', $title, $content);
      $content = str_replace('{$ROUTE}', $route, $content);
      $content = str_replace('{$FOLDER}', $table_name, $content);
      $content = str_replace('{$FIRST_COLUMN}', array_first($fillable_columns_names), $content);

      $chunks = $collection->chunk(3);
      $chunks = $chunks->toArray();

      $table_header = view('autogen/partials/_view-index-table-header')->with('columns', array_first($chunks))->render();
      $content = str_replace('{$TABLE_HEADER}', $table_header, $content);

      $table_body = view('autogen/partials/_view-index-table-body')->with('columns', array_first($chunks))->render();
      $content = str_replace('{$TABLE_BODY}', $table_body, $content);

      file_put_contents($file, $content);

      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * generate create view
   * @param  [string] $table_name [name of table]
   * @return [bool]               [if file creation is TRUE or FALSE]
   */
  private function _view_create($table_name)
  {
    // create folder if not exist
    $folder = '../resources/views/admin/' . $table_name;
    if (! is_dir($folder)) {
      mkdir($folder);
    }

    $title = ucfirst($table_name);
    $route = ucfirst($table_name);

    $file = $folder . '/create.blade.php';
    if (! file_exists($file))
    {
      $content = file_get_contents($this->dir . 'views/create.blade.php');

      $content = str_replace('{$TITLE}', $title, $content);
      $content = str_replace('{$ROUTE}', $route, $content);
      $content = str_replace('{$FOLDER}', $table_name, $content);

      file_put_contents($file, $content);

      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * generate edit view
   * @param  [string] $table_name [name of table]
   * @return [bool]               [if file creation is TRUE or FALSE]
   */
  private function _view_edit($table_name)
  {
    // create folder if not exist
    $folder = '../resources/views/admin/' . $table_name;
    if (! is_dir($folder)) {
      mkdir($folder);
    }

    $title = ucfirst($table_name);
    $route = ucfirst($table_name);

    $file = $folder . '/edit.blade.php';
    if (! file_exists($file))
    {
      $content = file_get_contents($this->dir . 'views/edit.blade.php');

      $content = str_replace('{$TITLE}', $title, $content);
      $content = str_replace('{$ROUTE}', $route, $content);
      $content = str_replace('{$FOLDER}', $table_name, $content);

      file_put_contents($file, $content);

      return true;
    }
    else
    {
      return false;
    }
  }

  private function _view_crop($table_name)
  {
    // create folder if not exist
    $folder = '../resources/views/admin/' . $table_name;
    if (! is_dir($folder)) {
      mkdir($folder);
    }

    $title = ucfirst($table_name);
    $route = ucfirst($table_name);

    $file = $folder . '/crop.blade.php';
    if (! file_exists($file))
    {
      $content = file_get_contents($this->dir . 'views/crop.blade.php');

      $content = str_replace('{$TITLE}', $title, $content);
      $content = str_replace('{$ROUTE}', $route, $content);

      file_put_contents($file, $content);

      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * generate form view
   * @param  [string] $table_name         [name of table]
   * @param  [array] $fillable_columns  [column details for form input]
   * @return [bool]                     [if file creation is TRUE or FALSE]
   */
  private function _view_form($table_name, $fillable_columns, $asset_columns)
  {
    $folder = '../resources/views/admin/' . $table_name;
    if (! is_dir($folder)) {
      mkdir($folder);
    }

    $prebuilt_views = ['enum', 'text', 'varchar'];
    $file = $folder . '/form.blade.php';
    if (! file_exists($file))
    {
      $inputs = '';

      foreach ($fillable_columns as $c) {
        // check if thumb
        $field = explode('_', $c['field']);
        if (! in_array('thumbnail', $field)) {
          // check if asset column
          $is_asset = false;
          foreach ($field as $f) {
            if (in_array($f, $asset_columns)) {
              $is_asset = true;
              break;
            }
          }

          if (! $is_asset) {
            $type = $c['type'];
            $view = (stripos($type, '(')) ? substr($type, 0, stripos($type, '(')) : $type;
            $is_required = ($c['null'] == 'YES') ? ", 'required'" : "";
            $column = [
              'name' => $c['field'],
              'placeholder' => ucfirst($c['field']),
              'is_required' => $is_required
            ];

            // set default view for column types
            if (! in_array($view, $prebuilt_views)) {
              $view = 'varchar';
            }

            $content = file_get_contents($this->dir . 'partials/_view-form-' . $view . '.blade.php');
            $content = str_replace('{$NAME}', $c['field'], $content);
            $content = str_replace('{$PLACEHOLDER}', ucfirst($c['field']), $content);
            $content = str_replace('{$REQUIRED}', $is_required, $content);

            if ($view == 'enum') {
              $options = substr($type, stripos($type, '('));
              $options = str_replace("'", "", trim(trim($options, '('), ')'));
              $options = explode(',', $options);
              $option_string = '';
              $i = 0;
              foreach ($options as $o) {
                  $option_string .= "'" . $o . "' => '" . $o . "'";
                  if ($i < (count($options) - 1)) {
                      $option_string .= ', ';
                  }
                  $i++;
              }
              $content = str_replace('{$OPTIONS}', $option_string, $content);
            }

            $inputs .= $content;
          } else {
            $content = file_get_contents($this->dir . 'partials/_view-form-asset.blade.php');
            $content = str_replace('{$NAME}', $c['field'], $content);
            $content = str_replace('{$PLACEHOLDER}', ucfirst($c['field']), $content);
            $route_name = ucfirst($table_name);
            $content = str_replace('{$ROUTE_NAME}', $route_name, $content);
            $inputs .= $content;
          }
        }
      }
      $content = file_get_contents($this->dir . 'views/form.blade.php');
      $content = str_replace('{$INPUTS}', $inputs, $content);
      file_put_contents($file, $content);

      return true;
    }
    else
    {
      return false;
    }
  }

  private function _view_show($table_name, $fillable_columns, $asset_columns)
  {
    $folder = '../resources/views/admin/' . $table_name;
    $file = $folder . '/show.blade.php';

    $inputs = '';

    foreach (array_slice($fillable_columns, 0, 5) as $c) {
      // check if thumb
      $field = explode('_', $c['field']);
      if (! in_array('thumbnail', $field)) {
        $view = 'varchar';
        // check if asset column
        foreach ($field as $f) {
          if (in_array($f, $asset_columns)) {
            $view = 'asset';
            break;
          }
        }

        $content = file_get_contents($this->dir . 'partials/_view-show-' . $view . '.blade.php');
        $content = str_replace('{$NAME}', $c['field'], $content);
        $content = str_replace('{$PLACEHOLDER}', ucfirst($c['field']), $content);
        $inputs .= $content;
      }
    }

    $content = file_get_contents($this->dir . 'views/show.blade.php');
    $content = str_replace('{$FIELDS}', $inputs, $content);
    $content = str_replace('{$ROUTE_NAME}', ucfirst($table_name), $content);
    file_put_contents($file, $content);

    dd($inputs);
    
    // dd(array_slice($fillable_columns, 0, 5));
  }

  private function _view_view($table_name, $all_columns, $fillable_columns, $asset_columns)
  {
    $folder = '../resources/views/admin/' . $table_name;
    $file = $folder . '/view.blade.php';

    $title = ucfirst($table_name);
    $route = ucfirst($table_name);

    $inputs = '';

    foreach ($all_columns as $a) {
      if (! strpos($a['field'], '_thumbnail')) {
        $view = 'varchar';
        if (strpos($a['field'], '_at')) {
          $view = 'datetime';
        } elseif (in_array($a['field'], $asset_columns)) {
          $view = 'asset';
        }

        $content = file_get_contents($this->dir . 'partials/_view-view-' . $view . '.blade.php');
        $content = str_replace('{$NAME}', $a['field'], $content);
        $content = str_replace('{$PLACEHOLDER}', ucfirst(str_replace('_', ' ', $a['field'])), $content);
        $inputs .= $content;
        // echo $a['field'] . ' - ' . $view . '<br>';
      }
    }

    $content = file_get_contents($this->dir . 'views/view.blade.php');
    $content = str_replace('{$TITLE}', $title, $content);
    $content = str_replace('{$ROUTE}', $route, $content);
    $content = str_replace('{$FIELDS}', $inputs, $content);
    // $content = str_replace('{$FIELDS}', $inputs, $content);
    // $content = str_replace('{$ROUTE_NAME}', ucfirst($table_name), $content);
    file_put_contents($file, $content);

    dd($all_columns);
  }
}
