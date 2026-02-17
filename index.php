<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2 Map Pick and Ban</title>
    <link href="./assets/css/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f1923 0%, #1a2a3a 50%, #0f1923 100%);
            color: #ece8e1;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background-attachment: fixed;
        }

        .container {
            background: rgba(31, 43, 56, 0.95);
            border-radius: 12px;
            padding: 30px;
            max-width: 800px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.8s ease-out;
        }

        .cs-title {
            font-family: 'Oswald', sans-serif;
            font-size: 3rem;
            color: #f59e0b;
            text-shadow: 0 0 15px rgba(245, 158, 11, 0.5);
            text-align: center;
            margin-bottom: 1.5rem;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input,
        .select {
            background: #2c3e50;
            border: none;
            color: #ece8e1;
        }

        .input::placeholder {
            color: #bdc3c7;
        }

        .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
            z-index: -1;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-blue {
            background-color: #3498db;
            box-shadow: 0 4px 0 #2980b9;
            transform: translateY(0);
        }

        .btn-blue:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #1f6f9f;
        }

        .btn-blue:active {
            transform: translateY(4px);
            box-shadow: 0 0 0 #2980b9;
        }

        .btn-red {
            background-color: #e74c3c;
            box-shadow: 0 4px 0 #c0392b;
            transform: translateY(0);
        }

        .btn-red:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #a93226;
        }

        .btn-red:active {
            transform: translateY(4px);
            box-shadow: 0 0 0 #c0392b;
        }

        .btn-yellow {
            background-color: #f1c40f;
            box-shadow: 0 4px 0 #d4ac0d;
            transform: translateY(0);
        }

        .btn-yellow:hover {
            background-color: #d4ac0d;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #b7950b;
        }

        .btn-yellow:active {
            transform: translateY(4px);
            box-shadow: 0 0 0 #d4ac0d;
        }

        .selected-map {
            color: red;
        }

        .map-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }
            
            .cs-title {
                font-size: 2.5rem;
            }
            
            .map-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 10px;
            }
            
            .map-card img {
                height: 80px;
            }
            
            .grid.grid-cols-2 {
                grid-template-columns: 1fr;
            }
            
            .grid.grid-cols-3 {
                grid-template-columns: 1fr;
                gap: 2px;
            }
            
            .flex.justify-between {
                flex-direction: column;
                gap: 10px;
            }
            
            .flex.justify-between button {
                width: 100%;
            }
            
            .mb-6.p-4.bg-gray-800.rounded-lg {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 15px;
                margin: 5px;
            }
            
            .cs-title {
                font-size: 2rem;
            }
            
            .map-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }
            
            .map-card img {
                height: 70px;
            }
            
            .map-card .map-label {
                font-size: 0.65rem;
                padding: 2px 4px;
            }
            
            .mb-6.p-4.bg-gray-800.rounded-lg {
                padding: 15px;
            }
        }

        .map-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            background: #0b141c;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(1);
        }

        .map-card img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .map-card .map-label {
            position: absolute;
            bottom: 6px;
            left: 6px;
            right: 6px;
            font-size: 0.75rem;
            background: rgba(0, 0, 0, 0.6);
            padding: 2px 6px;
            border-radius: 4px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .map-card.selected {
            border-color: #f59e0b;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.5);
            transform: scale(1.05);
        }

        .map-card.selected .map-label {
            background: rgba(245, 158, 11, 0.8);
            font-weight: bold;
        }

        .map-card:hover {
            border-color: #64748b;
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .map-card:hover img {
            transform: scale(1.1);
        }

        .map-card:hover .map-label {
            background: rgba(0, 0, 0, 0.8);
        }

        .map-card.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(50%);
        }

        .map-card.disabled:hover {
            transform: none;
            box-shadow: none;
            border-color: transparent;
        }

        .map-card.disabled:hover img {
            transform: none;
        }

        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background: #111827;
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            min-width: 240px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast.success {
            background: #16a34a;
            box-shadow: 0 0 15px rgba(22, 163, 74, 0.5);
        }

        .toast.error {
            background: #dc2626;
            box-shadow: 0 0 15px rgba(220, 38, 38, 0.5);
        }

        .submitted-list {
            max-height: 180px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .submitted-list::-webkit-scrollbar {
            width: 6px;
        }

        .submitted-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 999px;
        }
    </style>
</head>

<body>
    <div id="toast" class="toast"></div>
    <div class="container mx-auto py-10">
            <h1 class="cs-title mb-8 text-center">CS2地图BP系统</h1>
            
            <!-- 观察位按钮 -->
            <div class="text-center mb-8">
                <button onclick="openObserverMode()" class="btn btn-blue text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    进入观察模式
                </button>
            </div>
        <div id="team-names-form" class="mb-8">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="team1" class="block">Team 1:</label>
                    <input type="text" id="team1" class="input w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Team 1 Name">
                </div>
                <div>
                    <label for="team2" class="block">Team 2:</label>
                    <input type="text" id="team2" class="input w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Team 2 Name">
                </div>
            </div>
            <div class="mb-4">
                <label for="matchFormat" class="block">赛制:</label>
                <select id="matchFormat" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="toggleBO1Type()">
                    <option value="BO1">BO1</option>
                    <option value="BO3" selected>BO3</option>
                    <option value="BO5">BO5</option>
                </select>
            </div>
            
            <!-- BO1类型选择 -->
            <div id="bo1-type-select" class="mb-4 hidden">
                <label for="bo1Type" class="block">BO1类型:</label>
                <select id="bo1Type" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Major" selected>Major</option>
                    <option value="IEM">IEM</option>
                </select>
                <div class="mt-2 text-sm text-gray-400">
                    <strong>Major:</strong> A队先Ban两张，B队Ban三张，A队再Ban一张<br>
                    <strong>IEM:</strong> A队先Ban一张，B队Ban两张，A队Ban两张，B队再Ban一张
                </div>
            </div>
            <div class="flex justify-between">
                <button onclick="saveTeamNames()" class="btn btn-blue text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">保存队伍名称</button>
                <button onclick="resetTeamNames()" class="btn btn-red text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">重置队伍名称</button>
            </div>
        </div>

        <div id="map-pick-ban-form" class="hidden">
            <div class="mb-6">
                <div class="mb-2 font-bold">选择地图</div>
                <div id="map-grid" class="map-grid"></div>
                <input type="hidden" id="selectedMap">
            </div>
            
            <!-- BP流程状态显示 -->
            <div class="mb-6 p-4 bg-gray-800 rounded-lg">
                <div class="font-bold mb-2">BP流程状态</div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <div class="text-sm text-gray-400">当前赛制</div>
                        <div id="current-format" class="font-bold">BO3</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-400">剩余Ban次数</div>
                        <div id="remaining-bans" class="font-bold">4</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-400">剩余Pick次数</div>
                        <div id="remaining-picks" class="font-bold">2</div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-sm text-gray-400">当前阶段</div>
                    <div id="current-phase" class="font-bold">Ban阶段</div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="team" class="block">队伍:</label>
                    <select id="team" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></select>
                </div>
                <div>
                    <label for="action" class="block">行为:</label>
                    <select id="action" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="updateSideSelect()">
                        <option value="Pick">Pick</option>
                        <option value="Ban">Ban</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input id="decider" type="checkbox" class="mr-2" onchange="toggleDecider()">
                    <span>Decider</span>
                </label>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="side" class="block">对方阵营:</label>
                    <select id="side" class="select w-full px-4 py-2 mt-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                        <option value="">无</option>
                        <option value="T">T</option>
                        <option value="CT">CT</option>
                        <option value="KNIFE">KNIFE（拼刀）</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-between">
                <button onclick="submitChoice()" class="btn btn-blue text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">提交</button>
                <button onclick="resetChoices()" class="btn btn-red text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">重置选择</button>
                <button onclick="resetAll()" class="btn btn-yellow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">重置所有数据</button>
            </div>
            <div class="mt-6">
                <div class="mb-2 font-bold">已提交BP</div>
                <ul id="submitted-choices" class="space-y-2 submitted-list"></ul>
            </div>
        </div>
    </div>

    <script>
        const mapOptions = [
            { value: 'Ancient', label: 'Ancient', image: './assets/images/de_ancient.png' },
            { value: 'Anubis', label: 'Anubis', image: './assets/images/de_anubis.png' },
            { value: 'Cache', label: 'Cache', image: './assets/images/de_cache.png' },
            { value: 'Dust2', label: 'Dust 2', image: './assets/images/de_dust2.png' },
            { value: 'Inferno', label: 'Inferno', image: './assets/images/de_inferno.png' },
            { value: 'Mirage', label: 'Mirage', image: './assets/images/de_mirage.png' },
            { value: 'Nuke', label: 'Nuke', image: './assets/images/de_nuke.png' },
            { value: 'Overpass', label: 'Overpass', image: './assets/images/de_overpass.png' },
            { value: 'Train', label: 'Train', image: './assets/images/de_train.png' },
            { value: 'Vertigo', label: 'Vertigo', image: './assets/images/de_vertigo.png' }
        ];

        let toastTimer;
        let bpStats = {
            bans: 4,
            picks: 2,
            phase: 'Ban阶段'
        };

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            clearTimeout(toastTimer);
            void toast.offsetWidth;
            toast.classList.add('show');
            toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2000);
        }

        function toggleBO1Type() {
            const matchFormat = document.getElementById('matchFormat').value;
            const bo1TypeSelect = document.getElementById('bo1-type-select');
            
            if (matchFormat === 'BO1') {
                bo1TypeSelect.classList.remove('hidden');
            } else {
                bo1TypeSelect.classList.add('hidden');
            }
        }

        function calculateBPStats() {
            const matchFormat = localStorage.getItem('matchFormat') || 'BO3';
            const bo1Type = localStorage.getItem('bo1Type') || 'Major';
            
            switch (matchFormat) {
                case 'BO1':
                    if (bo1Type === 'Major') {
                        // Major: A队先Ban两张，B队Ban三张，A队再Ban一张
                        bpStats = {
                            bans: 6, // 2+3+1
                            picks: 0, // 无Pick，剩余的最后一张即为比赛地图
                            phase: 'Ban阶段'
                        };
                    } else {
                        // IEM: A队先Ban一张，B队Ban两张，A队Ban两张，B队再Ban一张
                        bpStats = {
                            bans: 6, // 1+2+2+1
                            picks: 0, // 无Pick，剩余的最后一张即为比赛地图
                            phase: 'Ban阶段'
                        };
                    }
                    break;
                case 'BO3':
                    // BO3: 各自BAN掉2张图之后，再各自PICK1张图，最后再BAN两张图，留下来的图作为DECIDER
                    bpStats = {
                        bans: 4, // 2+2
                        picks: 2, // 1+1
                        phase: 'Ban阶段'
                    };
                    break;
                case 'BO5':
                    // BO5: 两队各ban一图，然后各自pick两张图，最后一张图作为DECIDER
                    bpStats = {
                        bans: 2, // 两队各ban一图
                        picks: 4, // 各自pick两张图
                        phase: 'Ban阶段'
                    };
                    break;
                default:
                    bpStats = {
                        bans: 4,
                        picks: 2,
                        phase: 'Ban阶段'
                    };
            }
            
            updateBPStatsDisplay();
        }

        function updateBPStatsDisplay() {
            const matchFormat = localStorage.getItem('matchFormat') || 'BO3';
            
            document.getElementById('current-format').textContent = matchFormat;
            document.getElementById('remaining-bans').textContent = bpStats.bans;
            document.getElementById('remaining-picks').textContent = bpStats.picks;
            document.getElementById('current-phase').textContent = bpStats.phase;
        }

        function updateBPStats(action) {
            const matchFormat = localStorage.getItem('matchFormat') || 'BO3';
            
            if (action === 'Ban' && bpStats.bans > 0) {
                bpStats.bans--;
            } else if (action === 'Pick' && bpStats.picks > 0) {
                bpStats.picks--;
            }
            
            // 更新BP阶段
            if (matchFormat === 'BO1') {
                // BO1只有Ban阶段，完成所有Ban后直接进入BP完成
                if (bpStats.bans === 0) {
                    bpStats.phase = 'BP完成';
                }
            } else {
                // BO3和BO5有Ban和Pick阶段
                if (bpStats.bans === 0) {
                    bpStats.phase = 'Pick阶段';
                }
                
                if (bpStats.bans === 0 && bpStats.picks === 0) {
                    bpStats.phase = 'BP完成';
                }
            }
            
            updateBPStatsDisplay();
        }

        function renderMapGrid() {
            const grid = document.getElementById('map-grid');
            grid.innerHTML = '';
            mapOptions.forEach(map => {
                const card = document.createElement('button');
                card.type = 'button';
                card.className = 'map-card';
                card.dataset.map = map.value;
                card.innerHTML = `
                    <img src="${map.image}" alt="${map.label}">
                    <div class="map-label">${map.label}</div>
                `;
                card.addEventListener('click', () => selectMap(map.value));
                grid.appendChild(card);
            });
        }

        function selectMap(map) {
            const selectedMapInput = document.getElementById('selectedMap');
            selectedMapInput.value = map;
            
            // 触发change事件，更新提交按钮状态
            const event = new Event('change', { bubbles: true });
            selectedMapInput.dispatchEvent(event);
            
            document.querySelectorAll('.map-card').forEach(card => {
                card.classList.toggle('selected', card.dataset.map === map);
            });
        }

        function validateTeamForm() {
            const team1 = document.getElementById('team1').value.trim();
            const team2 = document.getElementById('team2').value.trim();
            const saveButton = document.querySelector('button[onclick="saveTeamNames()"]');
            
            if (team1 && team2) {
                saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
                saveButton.disabled = false;
            } else {
                saveButton.classList.add('opacity-50', 'cursor-not-allowed');
                saveButton.disabled = true;
            }
        }

        function saveTeamNames() {
            const team1 = document.getElementById('team1').value.trim();
            const team2 = document.getElementById('team2').value.trim();
            const matchFormat = document.getElementById('matchFormat').value;
            const saveButton = document.querySelector('button[onclick="saveTeamNames()"]');

            if (team1 && team2) {
                // 显示加载状态
                const originalText = saveButton.textContent;
                saveButton.textContent = '保存中...';
                saveButton.disabled = true;
                
                fetch('saveTeams.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        team1,
                        team2,
                        matchFormat
                    })
                }).then(response => response.json()).then(data => {
                    // 恢复按钮状态
                    saveButton.textContent = originalText;
                    saveButton.disabled = false;
                    
                    if (data.success) {
                            localStorage.setItem('team1', team1);
                            localStorage.setItem('team2', team2);
                            localStorage.setItem('matchFormat', matchFormat);
                            // 保存BO1类型
                            if (matchFormat === 'BO1') {
                                const bo1Type = document.getElementById('bo1Type').value;
                                localStorage.setItem('bo1Type', bo1Type);
                            } else {
                                localStorage.removeItem('bo1Type');
                            }
                            loadTeams();
                            document.getElementById('team-names-form').classList.add('hidden');
                            document.getElementById('map-pick-ban-form').classList.remove('hidden');
                            // 计算BP统计数据
                            calculateBPStats();
                            showToast('队伍名称已保存', 'success');
                        } else {
                            showToast('设置队伍名称失败', 'error');
                        }
                }).catch(error => {
                    // 恢复按钮状态
                    saveButton.textContent = originalText;
                    saveButton.disabled = false;
                    showToast('设置队伍名称失败', 'error');
                });
            } else {
                showToast('请输入队伍名称', 'error');
            }
        }

        function resetTeamNames() {
            fetch('resetTeams.php', {
                method: 'POST'
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    document.getElementById('team1').value = '';
                    document.getElementById('team2').value = '';
                    document.getElementById('team-names-form').classList.remove('hidden');
                    document.getElementById('map-pick-ban-form').classList.add('hidden');
                    localStorage.removeItem('team1');
                    localStorage.removeItem('team2');
                    localStorage.removeItem('matchFormat');
                    document.getElementById('matchFormat').value = 'BO3';
                    showToast('队伍名称已重置', 'success');
                } else {
                    showToast('重置队伍名称失败', 'error');
                }
            });
        }

        function loadTeams() {
            const team1 = localStorage.getItem('team1');
            const team2 = localStorage.getItem('team2');

            if (team1 && team2) {
                const teamSelect = document.getElementById('team');
                teamSelect.innerHTML = `
                    <option value="${team1}">${team1}</option>
                    <option value="${team2}">${team2}</option>
                `;
            }
        }

        function updateSideSelect() {
            const action = document.getElementById('action').value;
            const isDecider = document.getElementById('decider').checked;
            const sideSelect = document.getElementById('side');
            // Decider模式下阵营选择可用，只有Ban操作时禁用
            sideSelect.disabled = action === 'Ban';
        }

        function toggleDecider() {
            const isDecider = document.getElementById('decider').checked;
            const teamSelect = document.getElementById('team');
            const actionSelect = document.getElementById('action');
            const sideSelect = document.getElementById('side');
            teamSelect.disabled = isDecider;
            actionSelect.disabled = isDecider;
            if (isDecider) {
                actionSelect.value = 'Pick';
                // Decider模式下阵营选择默认为无阵营
                sideSelect.value = '';
            }
            updateSideSelect();
        }

        function formatChoice(choice) {
            const isDecider = choice.team === 'DECIDER';
            if (isDecider) {
                const sideText = choice.side ? ` - ${choice.side}` : '';
                return `DECIDER - ${choice.map}${sideText}`;
            }
            const actionText = choice.action === 'Pick' ? 'PICK' : 'BAN';
            const sideText = choice.action === 'Pick' && choice.side ? ` | ${choice.team} CHOSE ${choice.side}` : '';
            return `${choice.team} ${actionText} ${choice.map}${sideText}`;
        }

        function loadSubmittedChoices() {
            fetch('getChoices.php')
                .then(response => response.json())
                .then(choices => {
                    const list = document.getElementById('submitted-choices');
                    list.innerHTML = '';
                    choices.forEach(choice => {
                        const li = document.createElement('li');
                        li.className = 'px-3 py-2 rounded bg-gray-800 flex justify-between items-center';
                        
                        const choiceText = document.createElement('span');
                        choiceText.textContent = formatChoice(choice);
                        li.appendChild(choiceText);
                        
                        const actions = document.createElement('div');
                        actions.className = 'flex gap-2';
                        
                        // 编辑按钮
                        const editButton = document.createElement('button');
                        editButton.className = 'text-blue-400 hover:text-blue-300 text-sm';
                        editButton.textContent = '编辑';
                        editButton.onclick = () => editChoice(choice);
                        actions.appendChild(editButton);
                        
                        // 删除按钮
                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'text-red-400 hover:text-red-300 text-sm';
                        deleteButton.textContent = '删除';
                        deleteButton.onclick = () => deleteChoice(choice.id);
                        actions.appendChild(deleteButton);
                        
                        li.appendChild(actions);
                        list.appendChild(li);
                    });
                });
        }

        function validateSubmitForm() {
            const map = document.getElementById('selectedMap').value;
            const isDecider = document.getElementById('decider').checked;
            const team = document.getElementById('team').value;
            const submitButton = document.querySelector('button[onclick="submitChoice()"]');
            
            if (map && (isDecider || team)) {
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                submitButton.disabled = false;
            } else {
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                submitButton.disabled = true;
            }
        }

        function submitChoice() {
            const isDecider = document.getElementById('decider').checked;
            const selectedTeam = document.getElementById('team').value;
            const team = isDecider ? 'DECIDER' : selectedTeam;
            const action = document.getElementById('action').value;
            const map = document.getElementById('selectedMap').value;
            const submitButton = document.querySelector('button[onclick="submitChoice()"]');

            if (!map) {
                showToast('请先选择地图', 'error');
                return;
            }

            // 显示加载状态
            const originalText = submitButton.textContent;
            submitButton.textContent = '提交中...';
            submitButton.disabled = true;

            const oppositeTeam = team === 'DECIDER' ? '' : ((team === localStorage.getItem('team1')) ? localStorage.getItem('team2') : localStorage.getItem('team1'));
            const side = (!isDecider && action === 'Pick') ? document.getElementById('side').value : '';

            const choice = {
                team,
                action,
                side: action === 'Pick' ? side : '',
                map,
                oppositeTeam: action === 'Pick' ? oppositeTeam : ''
            };

            // 编辑模式：先删除旧的选择，再提交新的选择
            if (editingChoiceId) {
                fetch('deleteChoice.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: editingChoiceId })
                }).then(response => response.json()).then(deleteData => {
                    if (deleteData.success) {
                        // 删除成功后提交新的选择
                        fetch('submitChoice.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(choice)
                        }).then(response => response.json()).then(data => {
                            // 恢复按钮状态
                            submitButton.textContent = originalText;
                            submitButton.disabled = false;
                            
                            if (data.success) {
                                showToast('编辑成功', 'success');
                                editingChoiceId = null;
                                selectMap(map);
                                loadSubmittedChoices();
                                // 禁用已选择的地图
                                disableSelectedMap(map);
                                // 更新BP统计数据
                                updateBPStats(action);
                            } else {
                                showToast('编辑失败: ' + (data.message || '未知错误'), 'error');
                                editingChoiceId = null;
                            }
                        }).catch(error => {
                            // 恢复按钮状态
                            submitButton.textContent = originalText;
                            submitButton.disabled = false;
                            showToast('编辑失败: 提交新选择时出错', 'error');
                            editingChoiceId = null;
                        });
                    } else {
                        // 恢复按钮状态
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                        showToast('编辑失败: 删除旧选择时出错', 'error');
                        editingChoiceId = null;
                    }
                }).catch(error => {
                    // 恢复按钮状态
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                    showToast('编辑失败: 删除旧选择时出错', 'error');
                    editingChoiceId = null;
                });
            } else {
                // 正常提交模式
                fetch('submitChoice.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(choice)
                }).then(response => response.json()).then(data => {
                    // 恢复按钮状态
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                    
                    if (data.success) {
                        showToast('提交成功', 'success');
                        selectMap(map);
                        loadSubmittedChoices();
                        // 禁用已选择的地图
                        disableSelectedMap(map);
                        // 更新BP统计数据
                        updateBPStats(action);
                    } else {
                        showToast('提交选择失败: ' + (data.message || '未知错误'), 'error');
                    }
                }).catch(error => {
                    // 恢复按钮状态
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                    showToast('提交选择失败', 'error');
                });
            }
        }

        function disableSelectedMap(map) {
            document.querySelectorAll('.map-card').forEach(card => {
                if (card.dataset.map === map) {
                    card.classList.add('disabled');
                    // 移除所有点击事件监听器
                    const newCard = card.cloneNode(true);
                    card.parentNode.replaceChild(newCard, card);
                }
            });
        }

        function resetChoices() {
            fetch('resetChoices.php', {
                method: 'POST'
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    showToast('选择已重置', 'success');
                    document.querySelectorAll('.map-card').forEach(card => {
                        card.classList.remove('selected', 'disabled');
                        // 重新添加点击事件
                        const map = card.dataset.map;
                        card.addEventListener('click', () => selectMap(map));
                    });
                    document.getElementById('selectedMap').value = '';
                    loadSubmittedChoices();
                    // 重新计算BP统计数据
                    calculateBPStats();
                } else {
                    showToast('重置选择失败', 'error');
                }
            });
        }

        let editingChoiceId = null;

        function editChoice(choice) {
            // 设置编辑模式标志
            editingChoiceId = choice.id;
            
            // 填充表单数据
            document.getElementById('decider').checked = choice.team === 'DECIDER';
            
            if (choice.team !== 'DECIDER') {
                document.getElementById('team').value = choice.team;
            }
            
            document.getElementById('action').value = choice.action;
            selectMap(choice.map);
            
            if (choice.side) {
                document.getElementById('side').value = choice.side;
            }
            
            // 更新Decider状态
            toggleDecider();
            
            // 更新Side选择状态
            updateSideSelect();
            
            showToast('编辑模式已激活，请修改后重新提交', 'success');
        }

        function deleteChoice(id) {
            if (confirm('确定要删除这个BP选择吗？')) {
                fetch('deleteChoice.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        showToast('删除成功', 'success');
                        loadSubmittedChoices();
                        // 重新启用已删除地图
                        resetChoices();
                    } else {
                        showToast('删除失败', 'error');
                    }
                });
            }
        }

        function resetAll() {
            resetTeamNames();
            resetChoices();
            showToast('所有数据已重置', 'success');
        }

        function openObserverMode() {
            // 在新窗口中打开观察模式页面
            window.open('display.php', '_blank', 'width=1000,height=600,top=100,left=100');
            showToast('观察模式已打开', 'success');
        }

        window.onload = function() {
            const team1 = localStorage.getItem('team1');
            const team2 = localStorage.getItem('team2');
            const matchFormat = localStorage.getItem('matchFormat');
            const bo1Type = localStorage.getItem('bo1Type');

            if (matchFormat) {
                document.getElementById('matchFormat').value = matchFormat;
            }

            if (bo1Type) {
                document.getElementById('bo1Type').value = bo1Type;
            }

            // 初始化BO1类型选择的显示状态
            toggleBO1Type();

            renderMapGrid();

            // 初始化按钮状态
            validateTeamForm();
            validateSubmitForm();

            // 添加实时验证事件监听器
            document.getElementById('team1').addEventListener('input', validateTeamForm);
            document.getElementById('team2').addEventListener('input', validateTeamForm);
            document.getElementById('selectedMap').addEventListener('change', validateSubmitForm);
            document.getElementById('team').addEventListener('change', validateSubmitForm);
            document.getElementById('decider').addEventListener('change', validateSubmitForm);
            document.getElementById('action').addEventListener('change', validateSubmitForm);

            if (team1 && team2) {
                loadTeams();
                document.getElementById('team-names-form').classList.add('hidden');
                document.getElementById('map-pick-ban-form').classList.remove('hidden');
                loadSubmittedChoices();
            }
        }
    </script>
</body>

</html>