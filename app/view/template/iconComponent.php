<?php
if (!function_exists('icon')) {
function icon($name, $class = 'w-5 h-5', $color = 'currentColor', $size = '24') {
    $strokeWidth = '2'; // Default stroke width
    $icons = [
        //Location
        'location' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <g stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <circle cx="12" cy="10" r="3"/>
                <path d="M12 2a8 8 0 0 0-8 8c0 1.892.402 3.13 1.5 4.5L12 22l6.5-7.5c1.098-1.37 1.5-2.608 1.5-4.5a8 8 0 0 0-8-8"/>
            </g>
        </svg>',

        //user
        'user' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <g fill="none">
                <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
                <path fill="currentColor" d="M16 14a5 5 0 0 1 4.995 4.783L21 19v1a2 2 0 0 1-1.85 1.995L19 22H5a2 2 0 0 1-1.995-1.85L3 20v-1a5 5 0 0 1 4.783-4.995L8 14zM12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10"/>
            </g>
        </svg>',

        //logout
        'logout' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7v2H5v14h7v2zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5z"/>
        </svg>',

        //menu
        'humbergerButton' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>',

        //user outline
        'userOutline' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd">
                <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
                <path fill="currentColor" d="M16 14a5 5 0 0 1 4.995 4.783L21 19v1a2 2 0 0 1-1.85 1.995L19 22H5a2 2 0 0 1-1.995-1.85L3 20v-1a5 5 0 0 1 4.783-4.995L8 14zm0 2H8a3 3 0 0 0-2.995 2.824L5 19v1h14v-1a3 3 0 0 0-2.824-2.995zM12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m0 2a3 3 0 1 0 0 6a3 3 0 0 0 0-6"/>
            </g>
        </svg>',

        //phone
        'phone' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24c1.12.37 2.33.57 3.57.57c.55 0 1 .45 1 1V20c0 .55-.45 1-1 1c-9.39 0-17-7.61-17-17c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02z"/>
        </svg>',

        //instagram
        'instagram' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M13.028 2c1.125.003 1.696.009 2.189.023l.194.007c.224.008.445.018.712.03c1.064.05 1.79.218 2.427.465c.66.254 1.216.598 1.772 1.153a4.9 4.9 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428c.012.266.022.487.03.712l.006.194c.015.492.021 1.063.023 2.188l.001.746v1.31a79 79 0 0 1-.023 2.188l-.006.194c-.008.225-.018.446-.03.712c-.05 1.065-.22 1.79-.466 2.428a4.9 4.9 0 0 1-1.153 1.772a4.9 4.9 0 0 1-1.772 1.153c-.637.247-1.363.415-2.427.465l-.712.03l-.194.006c-.493.014-1.064.021-2.189.023l-.746.001h-1.309a78 78 0 0 1-2.189-.023l-.194-.006a63 63 0 0 1-.712-.031c-1.064-.05-1.79-.218-2.428-.465a4.9 4.9 0 0 1-1.771-1.153a4.9 4.9 0 0 1-1.154-1.772c-.247-.637-.415-1.363-.465-2.428l-.03-.712l-.005-.194A79 79 0 0 1 2 13.028v-2.056a79 79 0 0 1 .022-2.188l.007-.194c.008-.225.018-.446.03-.712c.05-1.065.218-1.79.465-2.428A4.9 4.9 0 0 1 3.68 3.678a4.9 4.9 0 0 1 1.77-1.153c.638-.247 1.363-.415 2.428-.465c.266-.012.488-.022.712-.03l.194-.006a79 79 0 0 1 2.188-.023zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10m0 2a3 3 0 1 1 .001 6a3 3 0 0 1 0-6m5.25-3.5a1.25 1.25 0 0 0 0 2.5a1.25 1.25 0 0 0 0-2.5"/>
        </svg>',

        //email
        'email' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M4 20q-.825 0-1.412-.587T2 18V6q0-.825.588-1.412T4 4h16q.825 0 1.413.588T22 6v12q0 .825-.587 1.413T20 20zm8-7l8-5V6l-8 5l-8-5v2z"/>
        </svg>',

        //arrow right
        'arrowRight' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
        </svg>',

        'arrowLeft' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M14 18L15.41 16.59L10.83 12L15.41 7.41L14 6L8 12z"/>
        </svg>',

        //plus
        'plus' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
        </svg>',

        //trash
        'trash' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 11v6m-4-6v6M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M4 7h16M7 7l2-4h6l2 4"/>
        </svg>',

        //arrow down
        'arrowDown' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m7 10l5 5l5-5"/>
        </svg>',

        //law
        'law' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M8.75.75V2h.985c.304 0 .603.08.867.231l1.29.736q.058.033.124.033h2.234a.75.75 0 0 1 0 1.5h-.427l2.111 4.692a.75.75 0 0 1-.154.838l-.53-.53l.529.531l-.001.002l-.002.002l-.006.006l-.006.005l-.01.01l-.045.04q-.317.265-.686.45C14.556 10.78 13.88 11 13 11a4.5 4.5 0 0 1-2.023-.454a3.5 3.5 0 0 1-.686-.45l-.045-.04l-.016-.015l-.006-.006l-.004-.004v-.001a.75.75 0 0 1-.154-.838L12.178 4.5h-.162c-.305 0-.604-.079-.868-.231l-1.29-.736a.25.25 0 0 0-.124-.033H8.75V13h2.5a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1 0-1.5h2.5V3.5h-.984a.25.25 0 0 0-.124.033l-1.289.737c-.265.15-.564.23-.869.23h-.162l2.112 4.692a.75.75 0 0 1-.154.838l-.53-.53l.529.531l-.001.002l-.002.002l-.006.006l-.016.015l-.045.04q-.317.265-.686.45C4.556 10.78 3.88 11 3 11a4.5 4.5 0 0 1-2.023-.454a3.5 3.5 0 0 1-.686-.45l-.045-.04l-.016-.015l-.006-.006l-.004-.004v-.001a.75.75 0 0 1-.154-.838L2.178 4.5H1.75a.75.75 0 0 1 0-1.5h2.234a.25.25 0 0 0 .125-.033l1.288-.737c.265-.15.564-.23.869-.23h.984V.75a.75.75 0 0 1 1.5 0m2.945 8.477c.285.135.718.273 1.305.273s1.02-.138 1.305-.273L13 6.327Zm-10 0c.285.135.718.273 1.305.273s1.02-.138 1.305-.273L3 6.327Z"/>
        </svg>',

        //calendar
        'calendar' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 2048 2048" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M1792 993q60 41 107 93t81 114t50 131t18 141q0 119-45 224t-124 183t-183 123t-224 46q-91 0-176-27t-156-78t-126-122t-85-157H128V128h256V0h128v128h896V0h128v128h256zM256 256v256h1408V256h-128v128h-128V256H512v128H384V256zm643 1280q-3-31-3-64q0-119 45-224t124-183t183-123t224-46q100 0 192 33V640H256v896zm573 384q93 0 174-35t142-96t96-142t36-175q0-93-35-174t-96-142t-142-96t-175-36q-93 0-174 35t-142 96t-96 142t-36 175q0 93 35 174t96 142t142 96t175 36m64-512h192v128h-320v-384h128z"/>
        </svg>',

        //cross
        'cross' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M18.36 19.78L12 13.41l-6.36 6.37l-1.42-1.42L10.59 12L4.22 5.64l1.42-1.42L12 10.59l6.36-6.36l1.41 1.41L13.41 12l6.36 6.36z"/>
        </svg>',

        //search
        'search' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l5.6 5.6q.275.275.275.7t-.275.7t-.7.275t-.7-.275l-5.6-5.6q-.75.6-1.725.95T9.5 16m0-2q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
        </svg>',

        //star
        'star' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>',

        //star fill
        'starFill' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="m5.825 21l1.625-7.025L2 9.25l7.2-.625L12 2l2.8 6.625l7.2.625l-5.45 4.725L18.175 21L12 17.275z"/>
        </svg>',

        //circle
        'circleFill' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12.003 21q-1.866 0-3.51-.708q-1.643-.709-2.859-1.924t-1.925-2.856T3 12.003t.709-3.51Q4.417 6.85 5.63 5.634t2.857-1.925T11.997 3t3.51.709q1.643.708 2.859 1.922t1.925 2.857t.709 3.509t-.708 3.51t-1.924 2.859t-2.856 1.925t-3.509.709"/>
        </svg>',

        // Camera Icon
        'camera' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>',

        // Upload Icon
        'upload' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
        </svg>',
        
        // Users/Avatar Icon
        'users' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>',
        
        // Sync/Refresh Icon
        'sync' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>',
        
        // Lock Icon
        'lock' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm6-10V7a3 3 0 00-3-3H9a3 3 0 00-3 3v2h8z"/>
        </svg>',

        // warning
        'warning' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12 16a1 1 0 1 0 1 1a1 1 0 0 0-1-1m10.67 1.47l-8.05-14a3 3 0 0 0-5.24 0l-8 14A3 3 0 0 0 3.94 22h16.12a3 3 0 0 0 2.61-4.53m-1.73 2a1 1 0 0 1-.88.51H3.94a1 1 0 0 1-.88-.51a1 1 0 0 1 0-1l8-14a1 1 0 0 1 1.78 0l8.05 14a1 1 0 0 1 .05 1.02ZM12 8a1 1 0 0 0-1 1v4a1 1 0 0 0 2 0V9a1 1 0 0 0-1-1"/>
        </svg>',

        // Book/Guide Icon
        // 'book' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        //     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        // </svg>',

        // Info Icon
        'info' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>',

        // Check Icon
        'check' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="' . $strokeWidth . '" d="M5 13l4 4L19 7"/>
        </svg>',
        
        // user Admin
        'userAdmin' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/>
        </svg>',

        // Ikon BARU: 'book' (Fill-based)
        'book' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M5 5v14a1 1 0 0 0 1 1h3v-2H7V6h2V4H6a1 1 0 0 0-1 1m14.242-.97l-8-2A1 1 0 0 0 10 3v18a.998.998 0 0 0 1.242.97l8-2A1 1 0 0 0 20 19V5a1 1 0 0 0-.758-.97M15 12.188a1.001 1.001 0 0 1-2 0v-.377a1 1 0 1 1 2 .001z"/>
        </svg>',

        //dashboardAdmin
        'dashboardAdmin' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M14 9q-.425 0-.712-.288T13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9zM4 13q-.425 0-.712-.288T3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13zm10 8q-.425 0-.712-.288T13 20v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21zM4 21q-.425 0-.712-.288T3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21z"/>
        </svg>',

        // document
        'document' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" fill-rule="evenodd" d="M2 1h14.5L22 6.5V23H2zm3 2v9l3-3l3 3V3z" clip-rule="evenodd"/>
        </svg>',

        //usersss
        'usersAdmin' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M16 17v2H2v-2s0-4 7-4s7 4 7 4m-3.5-9.5A3.5 3.5 0 1 0 9 11a3.5 3.5 0 0 0 3.5-3.5m3.44 5.5A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4M15 4a3.4 3.4 0 0 0-1.93.59a5 5 0 0 1 0 5.82A3.4 3.4 0 0 0 15 11a3.5 3.5 0 0 0 0-7"/>
        </svg>',

        // file
        'fileList' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>',

        //pencil
        'pencil' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="m14.06 9l.94.94L5.92 19H5v-.92zm3.6-6c-.25 0-.51.1-.7.29l-1.83 1.83l3.75 3.75l1.83-1.83c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29m-3.6 3.19L3 17.25V21h3.75L17.81 9.94z"/>
        </svg>',

        //uploadd
        'uploadFoto' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M9 16h6v-6h4l-7-7l-7 7h4zm-4 2h14v2H5z"/>
        </svg>',

        // bin
        'bin' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <g stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                <path stroke-dasharray="24" stroke-dashoffset="24" d="M12 20h5c0.5 0 1 -0.5 1 -1v-14M12 20h-5c-0.5 0 -1 -0.5 -1 -1v-14">
                    <animate fill="freeze" attributeName="stroke-dashoffset"/>
                </path>
                <path stroke-dasharray="20" stroke-dashoffset="20" d="M4 5h16">
                    <animate fill="freeze" attributeName="stroke-dashoffset"/>
                </path>
                <path stroke-dasharray="8" stroke-dashoffset="8" d="M10 4h4M10 9v7M14 9v7">
                    <animate fill="freeze" attributeName="stroke-dashoffset"/>
                </path>
            </g>
        </svg>',

        //suspend
        'suspend' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path fill="none" stroke="currentColor" stroke-linejoin="round" d="M6.5 5v6m3 0V5m5 3a6.5 6.5 0 1 1-13 0a6.5 6.5 0 0 1 13 0Z" stroke-width="1"/>
        </svg>',

        //plusZoom
        'plusZoom' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>',

        //minus
        'minusZoom' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
        </svg>',

        //refresh
        'refresh' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12 20q-3.35 0-5.675-2.325T4 12t2.325-5.675T12 4q1.725 0 3.3.712T18 6.75V4h2v7h-7V9h4.2q-.8-1.4-2.187-2.2T12 6Q9.5 6 7.75 7.75T6 12t1.75 4.25T12 18q1.925 0 3.475-1.1T17.65 14h2.1q-.7 2.65-2.85 4.325T12 20"/>
        </svg>',

        //paperClip
        'paperClip' => '<svg class="' . $class . '" fill="none" stroke="' . $color . '" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
            <path fill="none" stroke="currentColor" stroke-linecap="round" d="M2.5 4v4.5c0 1.7 1.3 3 3 3s3-1.3 3-3v-6c0-1.1-.9-2-2-2s-2 .9-2 2v6c0 .6.4 1 1 1s1-.4 1-1V4" stroke-width="1"/>
        </svg>',

        //fileUpload
        'fileUpload' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M0 64C0 28.7 28.7 0 64 0h160v128c0 17.7 14.3 32 32 32h128v288c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64zm384 64H256V0z"/>
        </svg>',

        //crossCircle
        'crossCircle' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10s10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59L9.41 8L8 9.41L10.59 12L8 14.59L9.41 16L12 13.41L14.59 16L16 14.59L13.41 12L16 9.41z"/>
        </svg>',

        //userShield
        'shieldUser' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12c5.16-1.26 9-6.45 9-12V5zm0 4a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m5.13 12A9.7 9.7 0 0 1 12 20.92A9.7 9.7 0 0 1 6.87 17c-.34-.5-.63-1-.87-1.53c0-1.65 2.71-3 6-3s6 1.32 6 3c-.24.53-.53 1.03-.87 1.53"/>
        </svg>',

        //documentExport
        'documentExport' => '<svg class="' . $class . '" fill="' . $color . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="m8 19.425l-2.25 2.25q-.3.3-.7.288t-.7-.313q-.275-.3-.287-.7t.287-.7L6.6 18H5.35q-.425 0-.712-.287T4.35 17t.288-.712T5.35 16H9q.425 0 .713.288T10 17v3.65q0 .425-.288.713T9 21.65t-.712-.287T8 20.65zM13 22q-.425 0-.712-.288T12 21v-4q0-1.25-.875-2.125T9 14H5q-.425 0-.712-.288T4 13V4q0-.825.588-1.412T6 2h8l6 6v12q0 .825-.587 1.413T18 22zm0-13h5l-5-5l5 5l-5-5z"/>
        </svg>'
    ];
    
    return $icons[$name] ?? '';
}
}
?>