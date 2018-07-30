<?php 

namespace Acme\Option;

use Illuminate\Support\Collection;
use App\Option as OptionModel;

class Option
{
  public function email()
  {
    $response = [];
    $response['name'] = OptionModel::slug('meta-title')->value;
    $response['number'] = OptionModel::slug('contact-number')->value;
    $response['email'] = OptionModel::slug('contact-email')->value;
    $response['facebook'] = OptionModel::slug('facebook-page')->value;
    $response['twitter'] = OptionModel::slug('twitter-page')->value;
    $response['google'] = OptionModel::slug('google-page')->value;
    $response['terms'] = OptionModel::slug('terms-link')->value;
    $response['privacy'] = OptionModel::slug('privacy-link')->value;
    $response['unsubscribe'] = OptionModel::slug('unsubscribe-link')->value;

    return $response;
  }
}