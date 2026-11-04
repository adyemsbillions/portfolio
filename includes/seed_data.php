<?php
/**
 * Starter content used by install.php. Everything here is editable later in the admin.
 */
return [

    'settings' => [
        'brand'            => 'adyems',
        'hero_pre'         => 'I build digital',
        'hero_emphasis'    => 'products',
        'hero_post'        => 'that work.',
        'hero_sub'         => 'Product-minded software developer creating useful web, mobile, and backend experiences—from first idea to production.',
        'owner_name'       => 'ADYEMS',
        'role_title'       => 'FULL-STACK BUILDER',
        'location'         => 'Maiduguri, Nigeria',
        'avatar'           => '', // falls back to the built-in illustration
        'stat_exp_value'   => '6+ YEARS',
        'stat_primary'     => 'Web / Mobile Products',
        'stat_stack'       => 'Backend / Frontend / Mobile',
        'capabilities_heading' => 'Built across the whole stack.',
        'capabilities_sub' => 'I care about the complete experience: sturdy systems underneath, thoughtful interfaces on top, and a clean path to shipping.',
        'work_heading'     => "Things I've made real.",
        'work_sub'         => 'Selected work — products shipped end to end.',
        'repos_url'        => 'https://github.com/adyemsbillions',
        'exp_heading'      => 'Shipped with good people.',
        'exp_sub'          => 'A growing track record of turning product requirements into stable, useful software for real teams and customers.',
        'contact_pre'      => 'Have a good idea?',
        'contact_emphasis' => "Let's build it.",
        'contact_sub'      => "Tell me what you're working on, what's stuck, or what you want to make possible. I'll get back to you with a thoughtful answer.",
        'email'            => 'iamadyems@gmail.com',
        'phone'            => '+234 906 151 2740',
        'whatsapp'         => '2349061512740',
        'github_url'       => 'https://github.com/adyemsbillions',
        'linkedin_url'     => '',
        'twitter_url'      => 'https://x.com/theadyems',
        'social_handle'    => '@theadyems',
        'footer_note'      => '© ' . date('Y') . ' ADYEMS — designed & built with intention.',
    ],

    // [num, title, category, items (one per line), icon]
    'skills' => [
        ['01', 'PHP & Laravel core', 'BACKEND', "Scalable Web Apps\nRESTful APIs\nCustom Software / Dashboards / Portals", 'server'],
        ['02', 'React, React Native & Flutter', 'FRONTEND & MOBILE', "React / React Native\nJavaScript\nWeb Apps / Mobile Applications", 'monitor'],
        ['03', 'Data & query layer', 'DATABASE', "MySQL / SQLite\nSchema Design\nOptimized Queries / Migrations", 'database'],
        ['04', 'Admin workflows', 'DASHBOARDS', "Admin Dashboards\nCRUD Interfaces\nWorkflow Automation", 'layout'],
        ['05', 'Delivery stack', 'TOOLING', "Flutter / Dart\nPayment Integrations\nGit / Postman / GitHub", 'tool'],
    ],

    // meta = [label1, value1, label2, value2, label3, value3]; empty pairs are hidden on the site
    'projects' => [
        [
            'title' => 'truszedproperties.com', 'badge' => 'LIVE PRODUCT', 'accent' => 'dark',
            'signal' => 'SEARCH: PROPERTY LISTINGS ONLINE',
            'desc'  => 'A real estate platform for Truszed Properties where buyers and renters search homes, duplexes, apartments and shortlets across Nigeria by state, property type, bedrooms and price range.',
            'tags'  => 'Real Estate, Listings, Search, PHP, MySQL',
            'm'     => ['TYPE', 'Real estate', 'MARKET', 'Nigeria', 'STATUS', 'Live'],
            'links' => [['Visit site', 'https://truszedproperties.com']],
        ],
        [
            'title' => 'dd.truszedproperties', 'badge' => 'LIVE · PROPTECH', 'accent' => 'purple',
            'signal' => 'RISK: PROPERTY ASSESSMENT ONLINE',
            'desc'  => 'A property verification and due-diligence platform: clients submit property details through a guided intake, the system runs legal, title and risk checks, and delivers a full report to their account. Includes a lawyer portal and client sign-in.',
            'tags'  => 'PropTech, Due Diligence, Reports, Lawyer Portal',
            'm'     => ['TYPE', 'PropTech', 'OUTPUT', 'Risk reports', 'STATUS', 'Live'],
            'links' => [['Visit site', 'https://dd.truszedproperties.com']],
        ],
        [
            'title' => 'ridge.org.ng', 'badge' => 'LIVE · LOGISTICS', 'accent' => 'dark',
            'signal' => 'DISPATCH: LIVE TRACKING ONLINE',
            'desc'  => 'Route optimisation and fleet management for urban motorcycle dispatch fleets — a sender portal, rider app and partner login with live delivery tracking, rider performance and route savings reporting.',
            'tags'  => 'Logistics, Route Optimisation, Live Tracking, Mobile-first',
            'm'     => ['TYPE', 'Logistics', 'USERS', 'Riders · Senders', 'STATUS', 'Live'],
            'links' => [['Visit site', 'https://ridge.org.ng']],
        ],
        [
            'title' => 'flri.org', 'badge' => 'CLIENT WORK', 'accent' => 'purple',
            'signal' => 'SITE: FLRI.ORG',
            'desc'  => 'Web development for FLRI.',
            'tags'  => 'Web',
            'm'     => ['CLIENT', 'FLRI', '', '', '', ''],
            'links' => [['Visit site', 'https://flri.org']],
        ],
        [
            'title' => 'cravii.ng', 'badge' => 'CLIENT WORK', 'accent' => 'dark',
            'signal' => 'SITE: CRAVII.NG',
            'desc'  => 'Web development for Cravii.',
            'tags'  => 'Web',
            'm'     => ['CLIENT', 'Cravii', '', '', '', ''],
            'links' => [['Visit site', 'https://cravii.ng']],
        ],
        [
            'title' => 'amhaci.org', 'badge' => 'CLIENT WORK', 'accent' => 'purple',
            'signal' => 'SITE: AMHACI.ORG',
            'desc'  => 'Web development for AMHACI.',
            'tags'  => 'Web',
            'm'     => ['CLIENT', 'AMHACI', '', '', '', ''],
            'links' => [['Visit site', 'https://amhaci.org']],
        ],
    ],

    // [company, role, period, description] — add your dates and roles in the admin
    'experiences' => [
        ['Truszed Properties', 'Developer', '', 'Worked on the Truszed property listing platform (truszedproperties.com) and the property due-diligence platform (dd.truszedproperties.com).'],
        ['RIDGE', 'Developer', '', 'Worked on RIDGE (ridge.org.ng), a route optimisation and dispatch management platform for delivery fleets.'],
        ['FLRI', 'Developer', '', 'Worked on flri.org.'],
        ['Cravii', 'Developer', '', 'Worked on cravii.ng.'],
        ['AMHACI', 'Developer', '', 'Worked on amhaci.org.'],
    ],
];
