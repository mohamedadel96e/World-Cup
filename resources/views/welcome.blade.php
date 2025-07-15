<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEFENSE COMMAND | Military Operations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {   
                        sans: ['Roboto Condensed', 'sans-serif'],
                    },
                    colors: {
                        gray: {
                            50: '#fafafa',
                            100: '#f5f5f5',
                            200: '#e5e5e5',
                            300: '#d4d4d4',
                            400: '#a3a3a3',
                            500: '#737373',
                            600: '#525252',
                            700: '#404040',
                            800: '#262626',
                            900: '#171717',
                            950: '#0a0a0a',
                        },
                        red: {
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
            background: linear-gradient(135deg, #171717 0%, #0a0a0a 100%);
            color: #e5e5e5;
            overflow: hidden;
            height: 100vh;
            margin: 0;
        }
        
        .military-border {
            border: 1px solid rgba(220, 38, 38, 0.3);
        }
        
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(220, 38, 38, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(220, 38, 38, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .status-active {
            background-color: #dc2626;
            box-shadow: 0 0 8px rgba(220, 38, 38, 0.8);
        }
        
        .terminal-text {
            font-family: 'Courier New', monospace;
            color: #dc2626;
        }
        
        .rank-badge {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #737373 0%, #404040 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #e5e5e5;
            font-weight: bold;
            border: 1px solid #dc2626;
        }
    </style>
</head>
<body class="h-screen flex flex-col">
    <!-- Top Command Bar -->
    <div class="flex items-center justify-between px-6 py-3 bg-black border-b border-red-700">
        <div class="flex items-center">
            <div class="status-indicator status-active"></div>
            <span class="text-red-600 font-mono text-sm">OPERATIONAL STATUS: ACTIVE</span>
        </div>
        <div class="text-sm text-gray-300">
            <span id="datetime" class="font-mono"></span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col md:flex-row flex-grow grid-pattern">
        <!-- Left Panel -->
        <div class="w-full md:w-2/5 flex flex-col p-8 fade-in">
            <div class="mb-8">
                <div class="text-gray-300 font-bold text-2xl tracking-wider border-b border-red-700 pb-2">
                    <span class="text-red-600">//</span> DEFENSE COMMAND
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mt-6">
                    Germany Winning Team
                </h1>
            </div>

            <div class="mt-4 mb-8">
                <p class="text-gray-400 leading-relaxed max-w-md">
                    Elite military forces dedicated to national security and global stability. 
                    Our strategic operations ensure peace through strength and readiness.
                </p>
            </div>

            <!-- Military Badges -->
            <div class="flex space-x-6 my-8">
                <div class="text-center">
                    <div class="rank-badge mx-auto mb-2">
                        <i class="fas fa-star text-red-600"></i>
                    </div>
                    <span class="text-xs text-gray-400">ELITE FORCES</span>
                </div>
                <div class="text-center">
                    <div class="rank-badge mx-auto mb-2">
                        <i class="fas fa-shield-alt text-red-600"></i>
                    </div>
                    <span class="text-xs text-gray-400">ARMORED DIV</span>
                </div>
                <div class="text-center">
                    <div class="rank-badge mx-auto mb-2">
                        <i class="fas fa-fighter-jet text-red-600"></i>
                    </div>
                    <span class="text-xs text-gray-400">AIR SUPPORT</span>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-6 flex flex-wrap gap-4">
                <a href="{{ route(name: 'register') }}">
                <button class="bg-red-700 text-white px-8 py-3 rounded-sm font-bold tracking-wider hover:bg-red-800 transition-colors pulse">
                    <i class="fas fa-flag mr-2"></i>JOIN THE ARMY
                </button>
                </a>
                <a href="{{ route(name: 'history') }}">
                <button class="border border-red-700 text-gray-300 px-8 py-3 rounded-sm font-medium hover:bg-gray-800 transition-colors">
                    HISTORICAL ARCHIVES
                </button>
                </a>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="w-full md:w-3/5 flex items-center justify-center p-8 fade-in" style="animation-delay: 0.2s;">
            <div class="bg-gray-900 bg-opacity-90 border border-red-700 w-full max-w-2xl p-8 rounded-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-300">STRATEGIC OPERATIONS</h2>
                    <span class="text-xs bg-red-700 px-2 py-1 text-gray-200">CLASSIFIED</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Card 1 -->
                    <div class="border border-red-700 p-5 bg-gray-800">
                        <div class="flex items-center mb-3">
                            <div class="bg-red-700 w-10 h-10 flex items-center justify-center mr-3">
                                <i class="fas fa-crosshairs text-gray-200"></i>
                            </div>
                            <h3 class="font-bold text-gray-200">TACTICAL READINESS</h3>
                        </div>
                        <p class="text-sm text-gray-400">
                            Advanced combat training and state-of-the-art equipment deployment.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="border border-red-700 p-5 bg-gray-800">
                        <div class="flex items-center mb-3">
                            <div class="bg-red-700 w-10 h-10 flex items-center justify-center mr-3">
                                <i class="fas fa-satellite text-gray-200"></i>
                            </div>
                            <h3 class="font-bold text-gray-200">SURVEILLANCE</h3>
                        </div>
                        <p class="text-sm text-gray-400">
                            24/7 global monitoring and intelligence gathering operations.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="border border-red-700 p-5 bg-gray-800">
                        <div class="flex items-center mb-3">
                            <div class="bg-red-700 w-10 h-10 flex items-center justify-center mr-3">
                                <i class="fas fa-user-shield text-gray-200"></i>
                            </div>
                            <h3 class="font-bold text-gray-200">SPECIAL FORCES</h3>
                        </div>
                        <p class="text-sm text-gray-400">
                            Elite units trained for high-risk covert operations worldwide.
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div class="border border-red-700 p-5 bg-gray-800">
                        <div class="flex items-center mb-3">
                            <div class="bg-red-700 w-10 h-10 flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-gray-200"></i>
                            </div>
                            <h3 class="font-bold text-gray-200">DEFENSE SYSTEMS</h3>
                        </div>
                        <p class="text-sm text-gray-400">
                            Cutting-edge missile defense and cyber warfare capabilities.
                        </p>
                    </div>
                </div>

                <!-- Status Board -->
                <div class="mt-8 pt-5 border-t border-red-700">
                    <h3 class="text-gray-300 font-bold mb-3">GLOBAL STATUS</h3>
                    <div class="flex flex-wrap gap-4 text-xs">
                        <div class="flex items-center">
                            <span class="status-indicator status-active mr-1"></span>
                            <span>PACIFIC: SECURE</span>
                        </div>
                        <div class="flex items-center">
                            <span class="status-indicator status-active mr-1"></span>
                            <span>EUROPE: SECURE</span>
                        </div>
                        <div class="flex items-center">
                            <span class="status-indicator bg-red-700 mr-1"></span>
                            <span>MIDDLE EAST: MONITORED</span>
                        </div>
                        <div class="flex items-center">
                            <span class="status-indicator status-active mr-1"></span>
                            <span>ASIA: SECURE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Terminal Output -->
    <div class="px-8 py-4 border-t border-red-700 bg-black">
        <div class="terminal-text font-mono text-sm flex items-center">
            <span class="text-red-600 mr-2">></span>
            <span id="terminal-output">INITIALIZING DEFENSE SYSTEMS... SYSTEMS ONLINE... ALL UNITS REPORT READY STATUS</span>
        </div>
    </div>


    <!-- Footer -->
    <footer class="py-3 px-6 bg-black text-xs text-gray-500 flex flex-col sm:flex-row justify-between items-center border-t border-red-700">
        <div>
            <span>DEFENSE COMMAND HQ • AUTHORIZED PERSONNEL ONLY</span>
        </div>
        <div class="flex space-x-4 mt-2 sm:mt-0">
            <span>ENCRYPTION: ACTIVE</span>
            <span>SECURITY LEVEL: DELTA</span>
            <span>ACCESS CODE: <span class="text-red-600">*******</span></span>
        </div>
    </footer>

    <script>
        // Update date and time
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                weekday: 'short'
            });
            const time = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit',
                hour12: true 
            });
            document.getElementById('datetime').textContent = `${date.toUpperCase()} | ${time}`;
        }
        
        // Initialize and update every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Add military-style terminal typing effect
        const terminalText = "DEFENSE SYSTEMS ACTIVE // ALL UNITS REPORT READY STATUS // THREAT LEVEL: NORMAL // STANDING BY FOR ORDERS...";
        let index = 0;
        const terminalOutput = document.getElementById('terminal-output');
        
        function typeTerminalText() {
            if (index < terminalText.length) {
                terminalOutput.textContent += terminalText.charAt(index);
                index++;
                setTimeout(typeTerminalText, 50);
            } else {
                // Blinking cursor effect
                setInterval(() => {
                    const cursorVisible = terminalOutput.textContent.endsWith('_');
                    terminalOutput.textContent = cursorVisible 
                        ? terminalOutput.textContent.slice(0, -1) 
                        : terminalOutput.textContent + '_';
                }, 500);
            }
        }
        
        // Start typing after a delay
        setTimeout(typeTerminalText, 1000);
        
        // Add animation delays
        document.querySelectorAll('.fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
</body>
</html>