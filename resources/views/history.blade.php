<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WWII History | Germany</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
            background-color: #0a0a0a;
            color: #e5e5e5;
            height: 100vh;
            overflow: hidden;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCI+CjxyZWN0IHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgZmlsbD0iIzA4MDgwOCIgLz4KPHBhdGggZD0iTTAgMEw1MCA1ME0yNSAwTDAgMjVNNTAgMjVMMjUgNTAiIHN0cm9rZT0iIzE0MTQxNCIgc3Ryb2tlLXdpZHRoPSIxIi8+Cjwvc3ZnPg==');
        }
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            background-color: #dc2626;
            box-shadow: 0 0 8px rgba(220, 38, 38, 0.8);
        }
        .leader-quote {
            border-left: 3px solid #dc2626;
            padding-left: 20px;
        }
        .map-container {
            position: relative;
            background: #262626;
            border: 1px solid #dc2626;
            overflow: hidden;
            height: 200px;
        }
        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 30px;
        }
        .timeline-item:before {
            content: "";
            position: absolute;
            left: 0;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #dc2626;
            box-shadow: 0 0 8px rgba(220, 38, 38, 0.8);
        }
        .timeline-item:after {
            content: "";
            position: absolute;
            left: 5px;
            top: 20px;
            bottom: -30px;
            width: 2px;
            background: #dc2626;
        }
        .timeline-item:last-child:after {
            display: none;
        }
        .battle-card {
            transition: all 0.3s ease;
            border: 1px solid #2c2c2c;
        }
        .battle-card:hover {
            border-color: #dc2626;
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }
        .tech-icon {
            font-size: 2rem;
            color: #dc2626;
            margin-bottom: 15px;
        }
        .classified-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(220, 38, 38, 0.2);
            color: #dc2626;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 3px;
            border: 1px solid #dc2626;
        }
        .fade-in {
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .map-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 8px;
            height: 100%;
        }
        .map-cell {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            position: relative;
        }
        .map-cell.active {
            background: #3a1a1a;
            border-color: #dc2626;
        }
        .map-cell.active:after {
            content: "✪";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #dc2626;
            font-size: 1.2rem;
            text-shadow: 0 0 10px rgba(220, 38, 38, 0.8);
        }
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .section-title:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, #dc2626, transparent);
        }
        .flicker {
            animation: flicker 3s infinite alternate;
        }
        @keyframes flicker {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
                opacity: 1;
            }
            20%, 24%, 55% {
                opacity: 0.3;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Top Command Bar -->

    <header class="w-full text-lg  not-has-[nav]:hidden pt-4 pr-4">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a
                        href="{{ url('/marketplace') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-lg leading-normal"
                    >
                        Marketplace
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-lg leading-normal"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 text-white bg-red-600 hover:bg-red-700 dark:text-white rounded-sm text-lg leading-normal"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>


    <div class="flex items-center justify-between px-6 py-3 bg-black border-b border-red-700">
        <div class="flex items-center">
            <div class="status-indicator flicker"></div>
            <span class="text-red-600 font-mono text-sm">HISTORICAL ARCHIVES - ONLINE</span>
        </div>
        <div class="text-sm text-gray-300">
            <span>GERMANY IN WORLD WAR II</span>
        </div>
        <div class="text-xs text-gray-500">
            <span>ACCESS LEVEL: <span class="text-red-500">CLASSIFIED</span></span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow overflow-y-auto">
        <div class="max-w-6xl mx-auto px-4 py-8">
            <!-- Page Header -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold mt-6">
                    <span class="text-gray-200">GERMAN WAR MACHINE</span>
                    <span class="text-red-600">1939-1945</span>
                </h1>
                <div class="mt-2 text-gray-500 text-sm">DOCUMENT CLASSIFICATION: TOP SECRET - EYES ONLY</div>
            </div>

            <!-- Leader Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16 fade-in">
                <div class="lg:col-span-1 flex justify-center">
                    <div class="relative">
                        <div class="bg-gray-800 border border-red-700 p-1">
                            <div class="bg-gray-700 w-full h-full" style="min-height:300px; min-width:300px; position:relative;">
                                <div class="absolute inset-0 flex items-center justify-center text-gray-500">
                                    <div class="text-center">
                                        <i class="fas fa-user-secret text-6xl mb-4"></i>
                                        <div>CLASSIFIED IMAGE</div>
                                        <div class="mt-4 text-xs">SECURITY CLEARANCE REQUIRED</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h3 class="text-xl font-bold text-gray-200">GENERAL H</h3>
                            <p class="text-gray-400">رئيس الحزب الناري (1933 - 1945)</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="border border-red-700 p-8 h-full">
                        <div class="leader-quote mb-6">
                            <blockquote class="text-xl italic text-gray-300">
                                "دي عالم عايزة الحرق."
                            </blockquote>
                            <p class="text-red-600 mt-2">- General H, 1933</p>
                        </div>

                        <div class="prose prose-invert">
                            <p class="text-gray-400 mb-4">
                                General H was an Austrian-born German politician who was the leader for Germany from 1933 until his suicide in 1945. His strategic vision transformed Germany into a formidable military power in just six years.
                            </p>
                            <p class="text-gray-400 font-bold">
                                News says that he faked his suicide to join our team in 2025 and work with us on this project.
                            </p>
                            <div class="mt-6 p-4 bg-gray-900 border border-dashed border-red-700">
                                <h4 class="text-red-500 font-bold mb-2">OPERATION PHOENIX - CURRENT STATUS</h4>
                                <div class="flex items-center text-sm">
                                    <div class="h-2 w-full bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-red-600 rounded-full" style="width: 45%"></div>
                                    </div>
                                    <span class="ml-3 text-red-500">45% COMPLETE</span>
                                </div>
                                <div class="mt-2 text-gray-500 text-xs">PROJECTED COMPLETION: Q4 2026</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brief History -->
            <div class="bg-black border border-red-700 p-6 mb-10">
                <div class="grid grid-cols-1 gap-4">
                    <h3 class="text-xl font-bold text-gray-200">1939: WAR BEGINS</h3>
                    <p class="text-gray-400">
                        Germany invaded Poland on September 1, 1939, triggering WWII. Blitzkrieg tactics proved devastatingly effective.
                    </p>

                    <h3 class="text-xl font-bold text-gray-200 mt-4">1940-1941: EUROPEAN DOMINANCE</h3>
                    <p class="text-gray-400">
                        Rapid conquest of Western Europe including France, Netherlands, Belgium, and Norway within months.
                    </p>

                    <h3 class="text-xl font-bold text-gray-200 mt-4">1941-1943: EASTERN FRONT</h3>
                    <p class="text-gray-400">
                        Operation Barbarossa - the largest invasion in history. Initial success followed by catastrophic defeat at Stalingrad.
                    </p>

                    <h3 class="text-xl font-bold text-gray-200 mt-4">1944-1945: DEFEAT</h3>
                    <p class="text-gray-400">
                        Allied invasion at Normandy, Soviet advance from the East, and final surrender in May 1945.
                    </p>

                    <div class="border border-red-700 border-dashed p-4 mt-6">
                    <h3 class="text-xl font-bold text-gray-200">2025-????: THE LEGEND AWAKENS</h3>
                    <p class="text-gray-200 font-bold">
                        A dedicated team is rebuilding the army using modern technologies. PHP battalions are being deployed to digital fronts.
                    </p>
                    <div class="mt-2 flex items-center">
                        <div class="bg-gray-800 px-2 py-1 text-xs text-red-500 border border-red-700 mr-2">PHP 8.3</div>
                        <div class="bg-gray-800 px-2 py-1 text-xs text-red-500 border border-red-700 mr-2">LARAVEL</div>
                        <div class="bg-gray-800 px-2 py-1 text-xs text-red-500 border border-red-700">DIGITAL BLITZKRIEG</div>
                    </div>
                    <br>
                    </div>
                </div>
            </div>

            <!-- New Content: Eastern Front Campaigns -->
            <div class="mb-12 fade-in">
                <h2 class="text-2xl font-bold text-gray-200 mb-6 section-title">EASTERN FRONT CAMPAIGNS</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="battle-card bg-gray-900 p-6 rounded">
                        <h3 class="text-xl font-bold text-red-600 mb-3">OPERATION BARBAROSSA</h3>
                        <div class="text-gray-500 text-sm mb-3">JUNE 22, 1941</div>
                        <p class="text-gray-400 mb-4">The largest military operation in history - 3 million Axis troops invaded the Soviet Union along 1,800 mile front.</p>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">GERMAN FORCES: 3.8M</span>
                            <span class="text-gray-500">SOVIET FORCES: 2.9M</span>
                        </div>
                    </div>

                    <div class="battle-card bg-gray-900 p-6 rounded">
                        <h3 class="text-xl font-bold text-red-600 mb-3">BATTLE OF STALINGRAD</h3>
                        <div class="text-gray-500 text-sm mb-3">AUG 23, 1942 - FEB 2, 1943</div>
                        <p class="text-gray-400 mb-4">One of the deadliest battles in history. Marked the turning point on the Eastern Front.</p>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">GERMAN LOSSES: 850,000</span>
                            <span class="text-gray-500">SOVIET LOSSES: 1.1M</span>
                        </div>
                    </div>

                    <div class="battle-card bg-gray-900 p-6 rounded">
                        <h3 class="text-xl font-bold text-red-600 mb-3">BATTLE OF KURSK</h3>
                        <div class="text-gray-500 text-sm mb-3">JULY 5 - AUG 23, 1943</div>
                        <p class="text-gray-400 mb-4">Largest tank battle in history with 6,000 tanks engaged. Ended German offensive capability.</p>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">TANKS DESTROYED: 3,000</span>
                            <span class="text-gray-500">CASUALTIES: 500,000</span>
                        </div>
                    </div>
                </div>

                <div class="map-container rounded-lg mb-8">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-map text-4xl text-gray-600 mb-3"></i>
                            <div class="text-gray-500">EASTERN FRONT STRATEGIC MAP</div>
                            <div class="text-xs text-gray-600 mt-2">ACCESS RESTRICTED</div>
                        </div>
                    </div>
                    <div class="map-grid">
                        <div class="map-cell"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell active"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell active"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell active"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell active"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell active"></div>
                        <div class="map-cell"></div>
                        <div class="map-cell"></div>
                    </div>
                </div>
            </div>

            <!-- New Content: Military Technology -->
            <div class="mb-12 fade-in">
                <h2 class="text-2xl font-bold text-gray-200 mb-6 section-title">MILITARY TECHNOLOGY</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-900 p-6 rounded border border-gray-800">
                        <div class="tech-icon">
                            <i class="fas fa-tank"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-200 mb-3">PANZER DIVISIONS</h3>
                        <p class="text-gray-400 mb-4">Germany revolutionized warfare with combined arms tactics centered around armored divisions. The Panzer IV became the workhorse of German armored forces.</p>
                        <div class="text-xs text-gray-500">
                            <span>PRODUCED: 8,500+</span>
                            <span class="mx-2">|</span>
                            <span>WEIGHT: 25 TONS</span>
                            <span class="mx-2">|</span>
                            <span>MAIN GUN: 75mm</span>
                        </div>
                    </div>

                    <div class="bg-gray-900 p-6 rounded border border-gray-800">
                        <div class="tech-icon">
                            <i class="fas fa-fighter-jet"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-200 mb-3">LUFTWAFFE AIR POWER</h3>
                        <p class="text-gray-400 mb-4">The Messerschmitt Bf 109 was the backbone of German fighter forces. Over 33,000 were produced, making it the most produced fighter aircraft in history.</p>
                        <div class="text-xs text-gray-500">
                            <span>TOP SPEED: 640 km/h</span>
                            <span class="mx-2">|</span>
                            <span>RANGE: 850 KM</span>
                            <span class="mx-2">|</span>
                            <span>ARMAMENT: 2x 13mm MG</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-900 p-6 rounded border border-gray-800">
                        <div class="tech-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-200 mb-3">V-2 ROCKET PROGRAM</h3>
                        <p class="text-gray-400 mb-4">The world's first long-range guided ballistic missile. Over 3,000 were launched at Allied targets, primarily London and Antwerp.</p>
                        <div class="text-xs text-gray-500">
                            <span>RANGE: 320 KM</span>
                            <span class="mx-2">|</span>
                            <span>WARHEAD: 1,000 KG</span>
                            <span class="mx-2">|</span>
                            <span>MAX SPEED: 5,760 km/h</span>
                        </div>
                    </div>

                    <div class="bg-gray-900 p-6 rounded border border-gray-800">
                        <div class="tech-icon">
                            <i class="fas fa-submarine"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-200 mb-3">U-BOAT WOLF PACKS</h3>
                        <p class="text-gray-400 mb-4">German submarines nearly severed Atlantic supply lines. At their peak in 1942, U-boats sank 6.5 million tons of Allied shipping.</p>
                        <div class="text-xs text-gray-500">
                            <span>SUBMARINES: 1,150</span>
                            <span class="mx-2">|</span>
                            <span>TONNAGE SUNK: 14M+</span>
                            <span class="mx-2">|</span>
                            <span>LOSSES: 785 U-BOATS</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- New Content: Project 2025 -->
            <div class="bg-gray-900 border border-red-700 p-6 rounded mb-12 fade-in">
                <div class="flex items-start">
                    <div class="bg-black p-3 rounded mr-4">
                        <i class="fas fa-user-secret text-3xl text-red-600"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-200 mb-2">PROJECT 2025: THE DIGITAL REICH</h2>
                        <p class="text-gray-400 mb-4">Classified sources indicate General H survived the war and has been working on a digital resurrection of German military capabilities using modern technologies.</p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="text-center p-4 bg-gray-800 rounded border border-gray-700">
                                <i class="fas fa-code text-2xl text-red-600 mb-2"></i>
                                <div class="font-bold text-gray-200">PHP ARMIES</div>
                                <div class="text-xs text-gray-500">Server-side battalions</div>
                            </div>

                            <div class="text-center p-4 bg-gray-800 rounded border border-gray-700">
                                <i class="fas fa-database text-2xl text-red-600 mb-2"></i>
                                <div class="font-bold text-gray-200">DATA BLITZKRIEG</div>
                                <div class="text-xs text-gray-500">Information warfare</div>
                            </div>

                            <div class="text-center p-4 bg-gray-800 rounded border border-gray-700">
                                <i class="fas fa-cloud text-2xl text-red-600 mb-2"></i>
                                <div class="font-bold text-gray-200">CLOUD LUFTWAFFE</div>
                                <div class="text-xs text-gray-500">Aerial data dominance</div>
                            </div>

                            <div class="text-center p-4 bg-gray-800 rounded border border-gray-700">
                                <i class="fas fa-shield-alt text-2xl text-red-600 mb-2"></i>
                                <div class="font-bold text-gray-200">CYBER PANZERS</div>
                                <div class="text-xs text-gray-500">Digital armor divisions</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="inline-block px-4 py-2 bg-red-900 text-red-300 border border-red-700 rounded text-sm">
                                <i class="fas fa-lock mr-2"></i> PROJECT DETAILS CLASSIFIED
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-3 px-6 bg-black text-xs text-gray-500 flex justify-between border-t border-red-700">
        <span>MILITARY HISTORICAL ARCHIVES</span>
        <span>ACCESS CODE: <span class="text-red-500">PHOENIX-2025</span></span>
        <span>LAST UPDATE: 07/14/2025</span>
    </footer>
</body>
</html>
