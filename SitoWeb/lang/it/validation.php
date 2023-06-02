<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attributo deve essere accettato.',
    'accepted_if' => ' :attribute deve essere accettato quando :other è :value.',
    'active_url' => ':attribute non è un URL valido.',
    'after' => ' :attribute deve essere una data successiva a :date.',
    'after_or_equal' => ' :attribute deve essere una data successiva o uguale a :date.',
    'alpha' => ' :attribute deve contenere solo lettere.',
    'alpha_dash' => ' :attribute deve contenere solo lettere, numeri, trattini e underscore.',
    'alpha_num' => ' :attribute deve contenere solo lettere e numeri.',
    'array' => ' :attribute deve essere un array.',
    'before' => ' :attribute deve essere una data precedente a :date.',
    'before_or_equal' => ' :attribute deve essere una data precedente o uguale a :date.',
    'tra' => [
        'numeric' => ' :attribute deve essere compreso tra :min e :max.',
        'file' => ' :attribute deve essere compreso tra :min e :max kilobyte.',
        'string' => ' :attribute deve essere compreso tra :min e :max caratteri.',
        'array' => ' :attribute deve essere compreso tra :min e :max elementi.',
    ],
    'boolean' => 'Il campo :attribute deve essere vero o falso',
    'confirmed' => 'La conferma del attributo :attribute non corrisponde',
    'current_password' => 'La password non è corretta',
    'date' => 'Attributo :attribute non è una data valida.',
    'date_equals' => 'Attributo :deve essere una data uguale a :date.',
    'date_format' => 'Attributo :non corrisponde al formato :format.',
    'declined' => 'Attributo :deve essere rifiutato',
    'declined_if' => 'Attributo :deve essere rifiutato quando :other è :value.',
    'different' => 'Attributo :e :altro devono essere diversi',
    'digits' => 'Attributo :deve essere :digits.',
    'digits_between' => 'Attributo :deve essere compreso tra :min e :max cifre.',
    'dimensioni' => 'Attributo :ha dimensioni del immagine non valide',
    'distinte' => 'Il campo :attributo ha un valore duplicato',
    'email' => 'Attributo :deve essere un indirizzo e-mail valido',
    'ends_with' => 'Attributo :deve terminare con uno dei seguenti: :values.',
    'enum' => 'Attributo :selezionato non è valido',
    'esiste' => 'Attributo :selezionato non è valido',
    'file' => 'Attributo :deve essere un file',
    'filled' => 'Il campo :attribute deve avere un valore',
    'gt' => [
        'numeric' => ' :attribute deve essere maggiore di :value.',
        'file' => ' :attribute deve essere maggiore di :value kilobytes.',
        'string' => ' :attribute deve essere maggiore di :value caratteri.',
        'array' => ' :attribute deve avere più di :value elementi.',
    ],
    'gte' => [
        'numeric' => ' :attribute deve essere maggiore o uguale a :value.',
        'file' => ' :attribute deve essere maggiore o uguale a :value kilobytes.',
        'string' => ' :attribute deve essere maggiore o uguale a :value caratteri.',
        'array' => ' :attribute deve avere :value elementi o più.',
    ],
    'image' => ' :attribute deve essere un immagine.',
    'in' => 'Attributo selezionato non è valido.',
    'in_array' => 'Il campo :attribute non esiste in :other.',
    'integer' => ' :attribute deve essere un numero intero.',
    'ip' => ':attributo deve essere un indirizzo IP valido.',
    'ipv4' => ' :attribute deve essere un indirizzo IPv4 valido.',
    'ipv6' => ' :attribute deve essere un indirizzo IPv6 valido.',
    'json' => ' :attribute deve essere una stringa JSON valida.',
    'lt' => [
        'numeric' => ' :attribute deve essere minore di :value.',
        'file' => ' :attribute deve essere minore di :value kilobytes.',
        'string' => ' :attribute deve essere minore di :value caratteri.',
        'array' => ' :attribute deve contenere meno di :value elementi.',
    ],
    'lte' => [
        'numeric' => ' :attribute deve essere minore o uguale a :value.',
        'file' => ' :attribute deve essere minore o uguale a :value kilobytes.',
        'string' => ' :attribute deve essere minore o uguale a :value caratteri.',
        'array' => ' :attribute non deve contenere più di :value elementi.',
    ],
    'mac_address' => ' :attribute deve essere un indirizzo MAC valido.',
    'massimo' => [
        'numeric' => ' :attribute non deve essere maggiore di :max.',
        'file' => ' :attribute non deve essere maggiore di :max kilobyte.',
        'string' => ' :attribute non deve essere maggiore di :max caratteri.',
        'array' => ' :attribute non deve contenere più di :max elementi.',
    ],
    'mimes' => ' :attribute deve essere un file di tipo: :values.',
    'mimetypes' => ' :attribute deve essere un file di tipo: :values.',
    'minimo' => [
        'numeric' => ' :attribute deve essere almeno :min.',
        'file' => ' :attribute deve essere almeno :min kilobyte.',
        'string' => ':attributo deve contenere almeno :min caratteri.',
        'array' => ' :attribute deve contenere almeno :min elementi.',
    ],
    'multiple_of' => ' :attribute deve essere un multiplo di :value.',
    'not_in' => 'Attributo selezionato non è valido.',
    'not_regex' => 'Il formato :attributo non è valido.',
    'numeric' => ':attributo deve essere un numero.',
    'password' => 'La password non è corretta.',
    'present' => 'Il campo :attribute deve essere presente.',
    'prohibited' => 'Il campo :attribute è proibito.',
    'prohibited_if' => 'Il campo :attribute è proibito quando :other è :value.',
    'prohibited_unless' => 'Il campo :attribute è proibito a meno che :other non sia in :values.',
    'prohibits' => 'Il campo :attribute impedisce la presenza di :other.',
    'regex' => 'Il formato :attributo non è valido.',
    'required' => 'Il campo :attribute è obbligatorio.',
    'required_array_keys' => 'Il campo :attribute deve contenere voci per: :values.',
    'required_if' => 'Il campo :attribute è obbligatorio quando :other è :value.',
    'required_unless' => 'Il campo :attribute è obbligatorio a meno che :other non sia in :values.',
    'required_with' => 'Il campo :attribute è obbligatorio quando :values ​​è presente.',
    'required_with_all' => 'Il campo :attribute è obbligatorio quando sono presenti :values.',
    'required_without' => 'Il campo :attribute è obbligatorio quando :values ​​non è presente.',
    'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno di :values ​​è presente.',
    'same' => ' :attribute e :other devono corrispondere.',
    'dimensione' => [
        'numeric' => ' :attributo deve essere :size.',
        'file' => ' :attribute deve essere :size kilobytes.',
        'string' => 'Attributo deve essere di :size caratteri.',
        'array' => ' :attribute deve contenere elementi :size.',
    ],
    'starts_with' => ' :attribute deve iniziare con uno dei seguenti: :values.',
    'string' => ' :attribute deve essere una stringa.',
    'timezone' => ' :attribute deve essere un fuso orario valido.',
    'unique' => ':attributo è già stato preso.',
    'uploaded' => 'Impossibile caricare :attribute.',
    'url' => ':attributo deve essere un URL valido.',
    'uuid' => ' :attribute deve essere un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'nome-attributo' => [
            'nome-regola' => 'messaggio-personalizzato',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
