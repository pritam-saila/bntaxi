<?php

/*
|--------------------------------------------------------------------------
| Driver & Vehicle Documentation
|--------------------------------------------------------------------------
|
| Every document a driver must supply is declared here, so adding, removing or
| re-configuring one (required? has an expiry date?) never needs a code change.
| The order below is the order documents are shown in the UI.
|
| Files are stored on the private "driver_documents" disk (see
| config/filesystems.php), encrypted at rest, and only ever streamed through
| authorised controller routes - never served straight from the web root.
|
*/

return [

    'disk' => 'driver_documents',

    // Maximum upload size in kilobytes (Laravel "max" rule unit). PHP's own
    // upload_max_filesize / post_max_size must be at least this large.
    'max_size_kb' => 10240,

    'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],

    // Checked against the file's real content (finfo), not the client's claim.
    'allowed_mimes' => ['application/pdf', 'image/jpeg', 'image/png'],

    // Expiry warnings: "Expires in N days" up to this many days out...
    'expiry_warning_days' => 30,
    // ...and the stronger "Expires soon" inside this window.
    'expiry_soon_days' => 14,

    'groups' => [
        'licence' => 'Driver Licence Documents',
        'bank'    => 'Bank Details',
        'vehicle' => 'Vehicle Documents',
    ],

    /*
     | type key => [
     |   label          Full name shown on the upload card
     |   short          Name used in the verification checklist
     |   group          One of the groups above
     |   description    Short instruction under the title
     |   required       Counts towards "Verified" when true
     |   has_issue_date Admin can record an issue date
     |   has_expiry     Admin can record an expiry date; it is then mandatory to approve
     | ]
     */
    'types' => [

        'driving_licence_front' => [
            'label'          => 'UK Driving Licence / PHV Driver Licence — Front',
            'short'          => 'Driver Licence (front)',
            'group'          => 'licence',
            'description'    => 'The front of your UK photocard driving licence or PHV driver licence. All four corners and every detail must be readable.',
            'required'       => true,
            'has_issue_date' => true,
            'has_expiry'     => true,
        ],

        'driving_licence_back' => [
            'label'          => 'UK Driving Licence / PHV Driver Licence — Back',
            'short'          => 'Driver Licence (back)',
            'group'          => 'licence',
            'description'    => 'The reverse of your licence, where applicable (photocard licences have entitlements printed on the back).',
            'required'       => false,
            'has_issue_date' => false,
            'has_expiry'     => false,
        ],

        'bank_statement' => [
            'label'          => 'Recent Bank Statement',
            'short'          => 'Bank Statement',
            'group'          => 'bank',
            'description'    => 'A statement from the last 3 months. The name on the account must match the account holder name you enter above.',
            'required'       => true,
            'has_issue_date' => true,
            'has_expiry'     => false,
        ],

        'phv_vehicle_licence' => [
            'label'          => 'PHV Vehicle Licence',
            'short'          => 'PHV Vehicle Licence',
            'group'          => 'vehicle',
            'description'    => 'The official Private Hire Vehicle licence issued by your local council for this vehicle.',
            'required'       => true,
            'has_issue_date' => true,
            'has_expiry'     => true,
        ],

        'hire_reward_insurance' => [
            'label'          => 'Hire & Reward Insurance Certificate',
            'short'          => 'Hire & Reward Insurance',
            'group'          => 'vehicle',
            'description'    => 'A valid certificate covering private hire / taxi work — standard social, domestic and pleasure cover is not enough.',
            'required'       => true,
            'has_issue_date' => true,
            'has_expiry'     => true,
        ],

        'vehicle_inspection' => [
            'label'          => 'UK Vehicle Inspection Certificate',
            'short'          => 'Vehicle Inspection Certificate',
            'group'          => 'vehicle',
            'description'    => 'Proof the vehicle has passed the required private hire vehicle inspection (e.g. council compliance test).',
            'required'       => true,
            'has_issue_date' => true,
            'has_expiry'     => true,
        ],

        'v5c_logbook' => [
            'label'          => 'V5C Vehicle Logbook',
            'short'          => 'V5C Logbook',
            'group'          => 'vehicle',
            'description'    => 'The V5C registration document showing the registered keeper, or the relevant lease / hire agreement information.',
            'required'       => true,
            'has_issue_date' => false,
            'has_expiry'     => false,
        ],
    ],
];
