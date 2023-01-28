# Installation Guide

### Clone the repository

    `git clone https://[YOUR_BITBUCKET_USERNAME]@bitbucket.org/bslandandhomemobile/bsunits-server.git`

### Install PHP Dependency 

    `composer install`
    
### Install and Compile CSS and JS Asset
    `npm install` 
    `npm run dev` 
### Copy .env.example to .env and edit it to match your application setting

    `mv .env.example .env`

### Generate application key

    `php artisan key:generate`

### Configure your .env file
        
    `DEFAULT_SYSTEM_USER_ID=1`
    `PHP_DATE_FORMAT="d-m-Y"`
    `PHP_DATETIME_FORMAT="d-m-Y H:i:s"`
    `JS_DATE_FORMAT="dd-mm-yyyy"`

### Configure .env file to connect to NAV Server

    `NAV_ODATA_SERVER_URL=[NAV_SERVER_ODATA_SERVICE_URL]`
    `NAV_ODATA_AUTH_KEY=[ODATA_AUTH_KEY]`

### Configure .env file for OneSignal Push Notification

    `ONESIGNAL_APP_ID=[ONESIGNAL_APP_ID]`
    `ONESIGNAL_REST_API_KEY=[ONESIGNAL_REST_API_KEY]`

### Configure .env file for Twilio SMS Service

    `TWILIO_AUTH_TOKEN=[AUTH_TOKEN]`
    `TWILIO_ACCOUNT_SID=[TWILIO_ACCOUNT_SID]`
    `TWILIO_FROM=[SENDER_NAME]`
    `TWILIO_ALPHANUMERIC_SENDER=[SENDER_ALPHANUMERIC]`

### Configure .env file for WK_HT ML_TO_PDF 

    `WKHTML_TO_PDF_BINARY=[PATH_TO_YOUR_WKHTMLTOPDF_BINARY]`

The application use [barryvdh/laravel-snappy](https://github.com/barryvdh/laravel-snappy) and [h4cc/wkhtmltopdf-amd64](https://github.com/h4cc/wkhtmltopdf-amd64) to workaround with PDF. Please refer to library homepage for installation and configuration.
        
### Run database migration 

    `php artisan migrate`

### Insert Default Data to database

    `php artisan db:seed --class=DummyDataSeeder`

    
### Install Laravel Passport for API Authentication

    `php artisan passport:install` 

This application used [Laravel Passport](https://laravel.com/docs/5.8/passport) for API Authentication. For further understanding please read the [Official Document](https://laravel.com/docs/5.8/passport)

For first-party API consumer (Mobile App), we used [Passport Grant](https://laravel.com/docs/5.8/passport#password-grant-tokens) to provide API Access token.
    
### Create a Symlink directory for file upload

    `php artisan storage:link`

Most of media upload in the application is proceeded by 2 packages: [intervention/image](http://image.intervention.io/getting_started/installation#laravel) and [spatie/laravel-medialibrary](https://spatie.be/docs/laravel-medialibrary/v7/introduction).

Please read the official document for more information.


# Developer Note
### DateTime object Format
This application provide the configuration of DateTime Format in __app/config/app.php__
2 elements were added to this configuration file (.env key : PHP_DATE_FORMAT, PHP_DATETIME_FORMAT)

1. __php_date_format__ :  the format which you want to echo by Carbon function  toSystemDateString()
2. __php_datetime_format__ : the format which you want to echo by Carbon function  toSystemDateTimeString()

the two funcitons were added in __app/Providers/AppServiceProvider.php. So, whenever you want to display the format from the above 2 variables please use these 2 function on Carbon Object accordingly.
About Carbon DateTime please refer to : [https://carbon.nesbot.com/docs/](https://carbon.nesbot.com/docs/)

for UI, this application is used [bootstrap-datepicker](https://bootstrap-datepicker.readthedocs.io/en/latest/). One more key (__js_date_format__) was added to  __app/config/app.php__ for managing the Date format of this JS library. 

In order to format back to Database friendly Date object, one funciton was added to __app\Http\Controllers\Controller.php__
    
    public function covertToStandardDateFormat($data, $date_key_array)
     {        
        foreach( $date_key_array as $key ) {
            if ( ! isset($data[$key]) ) {
                continue;
            }
            $format = config('app.php_date_format');
            $data[$key] = \Carbon\Carbon::createFromFormat($format, $data[$key])->startOfDay()->format('Y-m-d');
        }
        return $data;
    }
    
the function take 2 arguments 
    -   $data : array (key => value) of user input, (e.g. $request->input())
    -   $date_key_array : array of keys which you want to convert the custom format to Database friendly format.

Suppose, you set the PHP_DATE_FORMATE="d-m-Y" and JS_DATE_FORMAT="dd-mm-yyyy" in your .env file, your .datepicker input will return "23-01-2019". So, you use this function to transform it back to "2019-01-23"

Example of store and update function in controller : 

    public function store(Request $request)
    {        
        $your_model = New YourModel();
        $data = $this->covertToStandardDateFormat($request->input(), $your_model->getDates());
        
        $your_model->fill($data);
        $your_model->save()
        
    }
    
    public function update(Request $request, $id)
    {
        $your_model = YourModel::findOrFail($id);
        $data = $this->covertToStandardDateFormat($request->input(), $your_model->getDates());
        
        $your_model->fill($data);
        $your_model->save()
    }

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).