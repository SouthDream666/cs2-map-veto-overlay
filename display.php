<?php
require_once __DIR__ . '/lang.php';
$lang_code = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'zh';
if (!in_array($lang_code, ['zh', 'en'])) {
    $lang_code = 'zh';
}
$lang = getLang($lang_code);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code === 'zh' ? 'zh-CN' : 'en'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['title']; ?> - <?php echo $lang['submittedChoices']; ?></title>
    <link href="./assets/css/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <!-- Importing a similar font -->
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('./assets/fonts/stratum2-bold-webfont.woff') format('woff');
            /* Use actual Valorant font if available */
        }

        html,
        body {
            font-family: 'Montserrat', sans-serif;
            background: transparent;
            height: 100%;
            overflow: hidden;
        }

        .map-box {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 12vw;
            height: 32vw;
            max-width: 200px;
            max-height: 580px;
            /*background:  url('https://images.prismic.io/rivalryglhf/3965b309-0510-4285-8aab-596753ed6ec9_Valorant-Maps.webp')*/ no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: 'Montserrat', 'Oswald', sans-serif;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .map-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
            display: none;
            /* Hide initially */
        }

        .map-info {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            color: white;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            /* Hide initially */
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .map-info .team {
            margin-top: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .map-info .side {
            margin-bottom: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .map-name {
            display: none;
            /* Hide initially */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .decider-box {
            background: #111827;
            border: 2px solid #f59e0b;
        }

        .decider-box .map-info {
            opacity: 1;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: space-between;
        }

        .decider-box .team,
        .decider-box .side {
            display: none;
        }

        .decider-box .map-name {
            display: block;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease both;
        }

        .animate-slide-down {
            animation: slideDown 0.8s ease both;
        }

        @keyframes slideUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            0% {
                opacity: 0;
                transform: translateY(-40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="text-white">
    <div class="w-full mx-auto py-10 px-16" style="overflow: hidden;">
        <h1 class="text-5xl font-bold mb-12 text-center">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-yellow-500"></span>
        </h1>
        <div id="maps-container" class="flex flex-nowrap justify-center gap-4 overflow-x-hidden overflow-y-hidden w-full" style="padding: 64px 140px;">
            <!-- 7 map boxes with default states -->
            <?php
            for ($i = 0; $i < 7; $i++) {
                echo '<div class="map-box" data-map="">
                    <img src="" alt="">
                    <div class="map-info">
                        <div class="team"></div>
                        <div class="side"></div>
                        <div class="map-name"></div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <script>
        // 多语言数据
        const lang = <?php echo json_encode($lang); ?>;
        const mapsData = {
            "Ancient": "./assets/images/de_ancient.png",
            "Anubis": "./assets/images/de_anubis.png",
            "Cache": "./assets/images/de_cache.png",
            "Dust2": "./assets/images/de_dust2.png",
            "Inferno": "./assets/images/de_inferno.png",
            "Mirage": "./assets/images/de_mirage.png",
            "Nuke": "./assets/images/de_nuke.png",
            "Overpass": "./assets/images/de_overpass.png",
            "Train": "./assets/images/de_train.png",
            "Vertigo": "./assets/images/de_vertigo.png"
        };


        let previousChoices = [];
        let animateFromBottom = true;
        let isInitialLoad = true;

        function loadChoices() {
            fetch('getChoices.php')
                .then(response => response.json())
                .then(choices => {
                    console.log('Choices received:', choices); // Log the received choices
                    const container = document.getElementById('maps-container');

                    const boxes = Array.from(container.children);
                    boxes.forEach(box => {
                        box.dataset.map = '';
                        box.classList.remove('decider-box');
                        const imgEl = box.querySelector('img');
                        const teamEl = box.querySelector('.team');
                        const sideEl = box.querySelector('.side');
                        const mapNameEl = box.querySelector('.map-name');
                        imgEl.src = '';
                        imgEl.alt = '';
                        imgEl.style.display = 'none';
                        teamEl.textContent = '';
                        teamEl.style.display = 'none';
                        sideEl.textContent = '';
                        sideEl.style.display = 'none';
                        mapNameEl.textContent = '';
                        mapNameEl.style.display = 'none';
                        box.querySelector('.map-info').style.opacity = 0;
                        box.style.background = '';
                    });

                    let staggerIndex = 0;
                    choices.forEach(choice => {
                        let mapBox = Array.from(container.children).find(box => box.dataset.map === choice.map);

                        if (!mapBox) {
                            // Use the next available empty map box
                            mapBox = Array.from(container.children).find(box => box.dataset.map === "");
                            mapBox.dataset.map = choice.map;
                        }

                        if (mapBox) {
                            const imgEl = mapBox.querySelector('img');
                            const teamEl = mapBox.querySelector('.team');
                            const sideEl = mapBox.querySelector('.side');
                            const mapNameEl = mapBox.querySelector('.map-name');

                            console.log('Updating map box:', {
                                map: choice.map,
                                team: choice.team,
                                action: choice.action,
                                side: choice.side,
                                oppositeTeam: choice.oppositeTeam
                            });

                            imgEl.src = mapsData[choice.map];
                            imgEl.alt = choice.map;
                            imgEl.style.display = 'block';
                            const isDecider = choice.team === 'DECIDER';
                            mapBox.classList.toggle('decider-box', isDecider);
                            mapNameEl.textContent = choice.map;
                            mapNameEl.style.display = 'block';
                            mapNameEl.style.position = 'absolute';
                            mapNameEl.style.top = '50%';
                            mapNameEl.style.bottom = 'auto';
                            mapNameEl.style.left = '50%';
                            mapNameEl.style.transform = 'translate(-50%, -50%)';
                            const teamText = isDecider ? lang.decider : (choice.team ? `${choice.team} ${choice.action === 'Pick' ? lang.picked : lang.banned}` : '');
                            teamEl.textContent = teamText;
                            teamEl.style.display = teamText ? 'block' : 'none';
                            const rawSide = (choice.side || '').trim();
                            let sideKey = rawSide.toUpperCase() === 'ATTACK' ? 'T' : (rawSide.toUpperCase() === 'DEFENSE' ? 'CT' : rawSide.toUpperCase());
                            let sideText = '';
                            
                            if (isDecider && sideKey) {
                                // Decider模式下的阵营显示
                                if (sideKey === 'KNIFE') {
                                    sideText = lang.knifeSide;
                                } else {
                                    sideText = sideKey;
                                }
                            } else if (!isDecider && choice.action === 'Pick' && sideKey) {
                                // 正常Pick模式下的阵营显示
                                if (sideKey === 'KNIFE') {
                                    sideText = lang.asKnife;
                                } else if (sideKey === 'T') {
                                    sideText = `${choice.oppositeTeam} ${lang.asT}`;
                                } else if (sideKey === 'CT') {
                                    sideText = `${choice.oppositeTeam} ${lang.asCT}`;
                                } else {
                                    sideText = `${choice.oppositeTeam} ${sideKey}`;
                                }
                            }
                            
                            sideEl.textContent = sideText;
                            sideEl.style.display = sideText ? 'block' : 'none';
                            // 设置阵营颜色
                            if (sideKey === 'CT') {
                                sideEl.style.color = '#0960b1ff';
                            } else if (sideKey === 'T') {
                                sideEl.style.color = '#d8a53d';
                            } else if (sideKey === 'KNIFE') {
                                sideEl.style.color = '#f59e0b';
                            } else {
                                sideEl.style.color = '';
                            }
                            mapBox.querySelector('.map-info').style.opacity = 1; // Show the map info
                            mapBox.style.background = 'none'; // Remove the gradient background

                            // Check if the choice is new or updated
                            const isUpdated = !previousChoices.some(prev =>
                                prev.map === choice.map &&
                                prev.team === choice.team &&
                                prev.action === choice.action &&
                                prev.side === choice.side &&
                                prev.oppositeTeam === choice.oppositeTeam
                            );

                            if (isUpdated) {
                                const animationClass = animateFromBottom ? 'animate-slide-up' : 'animate-slide-down';
                                animateFromBottom = !animateFromBottom;
                                const delayMs = staggerIndex * 1500;
                                staggerIndex += 1;

                                mapBox.classList.remove('animate-slide-up', 'animate-slide-down');
                                mapBox.style.animationDelay = `${delayMs}ms`;
                                mapBox.classList.add(animationClass);

                                mapBox.addEventListener('animationend', () => {
                                    mapBox.classList.remove(animationClass);
                                    mapBox.style.animationDelay = '';
                                }, {
                                    once: true
                                });
                            }
                        }
                    });

                    // Update previous choices
                    previousChoices = JSON.parse(JSON.stringify(choices));
                    isInitialLoad = false;
                })
                .catch(error => console.error('Error fetching choices:', error));
        }

        window.onload = function() {
            loadChoices();
            setInterval(loadChoices, 2000); // Refresh every 5 seconds
        }
    </script>
</body>

</html>