<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => 'http://localhost',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'SomeRandomString'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => 'single',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Routing\ControllerServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Illuminate\Html\HtmlServiceProvider::class

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'       => Illuminate\Support\Facades\App::class,
        'Artisan'   => Illuminate\Support\Facades\Artisan::class,
        'Auth'      => Illuminate\Support\Facades\Auth::class,
        'Blade'     => Illuminate\Support\Facades\Blade::class,
        'Bus'       => Illuminate\Support\Facades\Bus::class,
        'Cache'     => Illuminate\Support\Facades\Cache::class,
        'Config'    => Illuminate\Support\Facades\Config::class,
        'Cookie'    => Illuminate\Support\Facades\Cookie::class,
        'Crypt'     => Illuminate\Support\Facades\Crypt::class,
        'DB'        => Illuminate\Support\Facades\DB::class,
        'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
        'Event'     => Illuminate\Support\Facades\Event::class,
        'File'      => Illuminate\Support\Facades\File::class,
        'Gate'      => Illuminate\Support\Facades\Gate::class,
        'Hash'      => Illuminate\Support\Facades\Hash::class,
        'Input'     => Illuminate\Support\Facades\Input::class,
        'Inspiring' => Illuminate\Foundation\Inspiring::class,
        'Lang'      => Illuminate\Support\Facades\Lang::class,
        'Log'       => Illuminate\Support\Facades\Log::class,
        'Mail'      => Illuminate\Support\Facades\Mail::class,
        'Password'  => Illuminate\Support\Facades\Password::class,
        'Queue'     => Illuminate\Support\Facades\Queue::class,
        'Redirect'  => Illuminate\Support\Facades\Redirect::class,
        'Redis'     => Illuminate\Support\Facades\Redis::class,
        'Request'   => Illuminate\Support\Facades\Request::class,
        'Response'  => Illuminate\Support\Facades\Response::class,
        'Route'     => Illuminate\Support\Facades\Route::class,
        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Session'   => Illuminate\Support\Facades\Session::class,
        'Storage'   => Illuminate\Support\Facades\Storage::class,
        'URL'       => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View'      => Illuminate\Support\Facades\View::class,
        'HTML' => Illuminate\Html\HtmlFacade::class,
        'Form' => Illuminate\Html\FormFacade::class,

    ],

    'basket_duration'=>15,

    'types'=>[
        'hidden' => ['id'],
        'name' => ['name', 'code', 'name_de', 'name_fr', 'name_en', 'path', 'title', 'last_name', 'first_name',
        'addition', 'street', 'city', 'country', 'type', 'company', 'phone', 'email', 'manufacturer'],
        'text' => ['comment'],
        'number' => ['number', 'zip'],
        'decimal' => ['fee'],
        'password' => ['password'],
        'check' => ['shipping'],
        'dropdown' => ['accessoryset_id', 'category_id', 'type_id', 'customer_id', 'purpose_id', 'location_id', 'source_id', 'division_id', 'language'],
        'date' => ['reserved_at', 'picked_at', 'return_until', 'returned_at', 'restocked_at'],
        'timestamp' => ['created_at', 'updated_at', 'return_date'],
        'document' => ['document_id'],
        'one' => ['available', 'working', 'complete', 'reseller'],
        'two' => ['color']
    ],

    'tomany' => [
        'object' => ['accessory'],
        'accessory' => ['accessoryset'],
        'accessoryset' => ['accessory'],
        ],

    'translations' => [
        'user' => ['de'=>'Benutzer', 'fr'=>'utilisateur', 'en'=>'user'],
        'company' => ['de'=>'Firma', 'fr'=>'société', 'en'=>'company'],
        'return_date' => ['de'=>'Rückgabedatum', 'fr'=>'date de retour', 'en'=>'return date'],
        'add' => ['de'=>'hinzufügen', 'fr'=>'ajouter', 'en'=>'add'],
        'reserve' => ['de'=>'reservieren', 'fr'=>'reserver', 'en'=>'reserve'],
        'reserved' => ['de'=>'reserviert', 'fr'=>'reservé', 'en'=>'reserved'],
        'request' => ['de'=>'anfragen', 'fr'=>'enquêter', 'en'=>'request'],
        'grant' => ['de'=>'bewilligen', 'fr'=>'granter', 'en'=>'grant'],
        'granted' => ['de'=>'bewilligt', 'fr'=>'granté', 'en'=>'granted'],
        'hand' => ['de'=>'aushändigen', 'fr'=>'livrer', 'en'=>'hand out'],
        'handout' => ['de'=>'aushändigen', 'fr'=>'livrer', 'en'=>'hand out'],
        'handed' => ['de'=>'ausgehändigt', 'fr'=>'livré', 'en'=>'handed out'],
        'restock' => ['de'=>'zurücknehmen', 'fr'=>'retirer', 'en'=>'restock'],
        'restocked' => ['de'=>'zurückgenommen', 'fr'=>'retiré', 'en'=>'restocked'],
        'customer' => ['de'=>'Kunde', 'fr'=>'client', 'en'=>'customer'],
        'dates' => ['de'=>'Daten', 'fr'=>'dates', 'en'=>'dates'],
        'shipping' => ['de'=>'versenden', 'fr'=>'envoyer', 'en'=>'to ship'],
        'purpose' => ['de'=>'Verwendungszweck', 'fr'=>'but', 'en'=>'purpose'],
        'categories' => ['de'=>'Kategorien', 'fr'=>'catégories', 'en'=>'categories'],
        'model' => ['de'=>'Modell', 'fr'=>'model', 'en'=>'model'],
        'models' => ['de'=>'Modelle', 'fr'=>'models', 'en'=>'models'],
        'object' => ['de'=>'Objekt', 'fr'=>'object', 'en'=>'object'],
        'objects' => ['de'=>'Objekte', 'fr'=>'objects', 'en'=>'objects'],
        'objectdetails' => ['de'=>'Objektdetails', 'fr'=>'details de l\'object', 'en'=>'objectdetails'],
        'name' => ['de'=>'Name', 'fr'=>'nom', 'en'=>'name'],
        'available' => ['de'=>'verfügbar', 'fr'=>'available', 'en'=>'available'],
        'working' => ['de'=>'funktionstüchtig', 'fr'=>'en service', 'en'=>'working'],
        'complete' => ['de'=>'vollständig', 'fr'=>'complète', 'en'=>'complete'],
        'accessories' => ['de'=>'Zubehör', 'fr'=>'accessoires', 'en'=>'accessories'],
        'switzerland' => ['de'=>'Schweiz', 'fr'=>'Suisse', 'en'=>'Switzerland'],
        'you_get_until' => ['de'=>'Sie erhalten leihweise bis am', 'fr'=>'Vous recevez jusqu\'au', 'en'=>'You get the following objects until'],
        'return_until' => ['de'=>'Rückgabedatum', 'fr'=>'date de retour', 'en'=>'return date'],
        'state' => ['de'=>'Status', 'fr'=>'state', 'en'=>'state'],
        'updated' => ['de'=>'erneuert', 'fr'=>'renouvelé', 'en'=>'updated'],
        'how_long' => ['de'=>'Wie lange dürfen die Objekte maximal ausgeliehen werden', 'fr'=>'Pendant combien des jours on peut louer les objects', 'en'=>'For how long can the objects be lended'],
        'how_many' => ['de'=>'Wieviele Objekte müssen vorrätig sein, um die Objekte ausleihen zu können', 'fr'=>'Combien des objects devent être available qu\'on peut les louer', 'en'=>'How many objects have to be in stock, that they can be rented'],
        'count' => ['de'=>'Anzahl', 'fr'=>'nombre', 'en'=>'count'],
        'browser' => ['de'=>'Objektauswahl', 'fr'=>'séléction des objects', 'en'=>'browser'],
        'basket' => ['de'=>'Anfragen', 'fr'=>'requêter', 'en'=>'request'],
        'lending' => ['de'=>'Ausleihe', 'fr'=>'louer', 'en'=>'lending'],
        'options' => ['de'=>'Einstellungen', 'fr'=>'options', 'en'=>'options'],
        'logout' => ['de'=>'Abmelden', 'fr'=>'quitter', 'en'=>'logout'],
        'error_occurred' => ['de'=>'Ein Fehler ist augetreten.', 'fr'=>'Un erreur s\'est produît.', 'en'=>'An error has occurred.'],
        'click_reload' => ['de'=>'Klicken Sie hier um die Seite neu zu laden.', 'fr'=>'Appuyez ici pour recharger la page', 'en'=>'Click here to reload the page.'],
        'no_user' => ['de'=>'Kein Benutzer angemeldet.', 'fr'=>'Pas d\'utilisateur.' , 'en'=>'No user logged in.'],
        'requests' => ['de'=>'Anfragen', 'fr'=>'enquêtes', 'en'=>'requests'],
        'are_you_sure' => ['de'=>'Sind Sie sicher? Bitte überprüfen Sie die Angaben, bevor Sie auf OK klicken', 'fr'=>'Êtes-vous sûr? Verifiez les information avant vous apuyez sur OK.', 'en'=>'Are you sure? Please verify the information before you klick OK.'],
        'are_you_sure_lock' => ['de'=>'Sind Sie sicher dass Sie die ausgewählten Objekte sperren wollen', 'fr'=>'Êtes-vous sûr que vous voulez bloquer les objècts choisis', 'en'=>'Are you sure you want to lock the selected objects?'],
        'returned' => ['de'=>'zurückerhalten', 'fr'=>'reçu', 'en'=>'returned'],
        'unlock' => ['de'=>'entsperren', 'fr'=>'debloquer', 'en'=>'unblock'],
        'lock' => ['de'=>'blockieren', 'fr'=>'bloquer', 'en'=>'block'],
        'locked'=> ['de'=>'gesperrt', 'fr'=>'bloqué', 'en'=>'locked'],
        'category'=> ['de'=>'Kategorie', 'fr'=>'catégorie', 'en'=>'category'],
        'addition'=> ['de'=>'Zusatz', 'fr'=>'addition', 'en'=>'addition'],
        'title'=> ['de'=>'Titel', 'fr'=>'title', 'en'=>'title'],
        'first_name'=> ['de'=>'Vorname', 'fr'=>'prenom', 'en'=>'first name'],
        'last_name'=> ['de'=>'Nachname', 'fr'=>'nom', 'en'=>'last name'],
        'street'=> ['de'=>'Strasse', 'fr'=>'rue', 'en'=>'street'],
        'number'=> ['de'=>'Hausnummer', 'fr'=>'numbre', 'en'=>'house number'],
        'zip'=> ['de'=>'PLZ', 'fr'=>'code postale', 'en'=>'ZIP'],
        'city'=> ['de'=>'Ort', 'fr'=>'cité', 'en'=>'city'],
        'country'=> ['de'=>'Land', 'fr'=>'pay', 'en'=>'land'],
        'language'=> ['de'=>'Sprache', 'fr'=>'langue', 'en'=>'language'],
        'reinvent'=> ['de'=>'neu erfassen', 'fr'=>'réinventer', 'en'=>'reinvent'],
        'german' => ['de'=>'deutsch', 'fr'=>'allemand', 'en'=>'German'],
        'french' => ['de'=>'französisch', 'fr'=>'français', 'en'=>'French'],
        'english' => ['de'=>'englisch', 'fr'=>'anglais', 'en'=>'english'],
        '0' => ['de'=>'nein', 'fr'=>'non', 'en'=>'no'],
        '1' => ['de'=>'ja', 'fr'=>'oui', 'en'=>'yes'],
        'send' => ['de'=>'versenden', 'fr'=>'envoyer', 'en'=>'send'],
        'pickup' => ['de'=>'abholen', 'fr'=>'prendre', 'en'=>'pick up'],
        'add_object' => ['de'=>'weitere Objekte hinzufügen', 'fr'=>'ajouter autres objècts', 'en'=>'add other objects'],
        'confirmation' => ['de'=>'Bestätigung', 'fr'=>'confirmation', 'en'=>'confirmation'],
        'reject' => ['de'=>'ablehnen', 'fr'=>'refuser', 'en'=>'reject'],
        'division' => ['de'=>'Abteilung', 'fr'=>'département', 'en'=>'division'],
        'phone' => ['de'=>'Telefon', 'fr'=>'téléphone', 'en'=>'phone'],
        'email' => ['de'=>'E-Mail', 'fr'=>'e-mail', 'en'=>'e-mail'],
    ],

    'rights'=>[
        'admin'=>['categories', 'types', 'objects', 'accessories', 'accessorysets', 'locations', 'sources', 'division', 'customer', 'language',
            'category', 'type', 'object', 'accessory', 'accessoryset', 'location', 'source', 'divisions', 'customers', 'languages'],
        'supervisor'=>['category', 'type', 'object', 'accessory', 'accessoryset', 'location', 'source', 'user', 'customer', 'source', 'division','language',
            'categories', 'types', 'objects', 'accessories', 'accessorysets', 'locations', 'sources', 'users', 'customers', 'sources', 'divisions', 'languages'],
        'user' => ['customer','language',
        'customers', 'languages']
    ]



];
