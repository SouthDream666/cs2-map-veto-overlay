<?php
// 多语言支持文件
function getLang($lang = 'zh') {
    $languages = [
        'zh' => [
            // 通用
            'title' => 'CS2地图BP系统',
            'save' => '保存',
            'reset' => '重置',
            'submit' => '提交',
            'success' => '成功',
            'error' => '失败',
            'loading' => '加载中...',
            
            // 队伍表单
            'team1' => 'Team 1:',
            'team2' => 'Team 2:',
            'matchFormat' => '赛制:',
            'enterTeam1' => '输入 Team 1 名称',
            'enterTeam2' => '输入 Team 2 名称',
            'saveTeamNames' => '保存队伍名称',
            'resetTeamNames' => '重置队伍名称',
            'saveSuccess' => '队伍名称已保存',
            'saveError' => '设置队伍名称失败',
            'enterTeamName' => '请输入队伍名称',
            'resetTeamSuccess' => '队伍名称已重置',
            'resetTeamError' => '重置队伍名称失败',
            
            // BO1类型
            'bo1Type' => 'BO1类型:',
            'major' => 'Major',
            'iem' => 'IEM',
            'majorDesc' => 'A队先Ban两张，B队Ban三张，A队再Ban一张',
            'iemDesc' => 'A队先Ban一张，B队Ban两张，A队Ban两张，B队再Ban一张',
            
            // 观察模式
            'observerMode' => '进入观察模式',
            'observerOpened' => '观察模式已打开',
            
            // 地图选择
            'selectMap' => '选择地图',
            
            // BP流程状态
            'bpStatus' => 'BP流程状态',
            'currentFormat' => '当前赛制',
            'remainingBans' => '剩余Ban次数',
            'remainingPicks' => '剩余Pick次数',
            'currentPhase' => '当前阶段',
            'banPhase' => 'Ban阶段',
            'pickPhase' => 'Pick阶段',
            'bpComplete' => 'BP完成',
            
            // 表单
            'team' => '队伍:',
            'action' => '行为:',
            'pick' => 'Pick',
            'ban' => 'Ban',
            'decider' => 'Decider',
            'oppositeSide' => '对面阵营:',
            'noSide' => '无阵营',
            't' => 'T',
            'ct' => 'CT',
            'knife' => 'KNIFE（拼刀）',
            
            // 按钮
            'submitButton' => '提交',
            'resetChoices' => '重置选择',
            'resetAll' => '重置所有数据',
            'submittedChoices' => '已提交BP',
            'edit' => '编辑',
            'delete' => '删除',
            
            // 消息
            'selectMapFirst' => '请先选择地图',
            'submitSuccess' => '提交成功',
            'submitError' => '提交选择失败',
            'resetChoicesSuccess' => '选择已重置',
            'resetChoicesError' => '重置选择失败',
            'resetAllSuccess' => '所有数据已重置',
            'editModeActive' => '编辑模式已激活，请修改后重新提交',
            'editSuccess' => '编辑成功',
            'editError' => '编辑失败',
            'deleteConfirm' => '确定要删除这个BP选择吗？',
            'deleteSuccess' => '删除成功',
            'deleteError' => '删除失败',
            'mapAlreadySelected' => '该地图已经被选择',
            'invalidAction' => '无效的操作类型',
            'invalidSide' => '无效的阵营选择',
            'databaseError' => '数据库操作失败',
            'serverError' => '服务器内部错误',
            'missingParams' => '缺少必要参数',
            
            // 阵营显示
            'decider' => 'DECIDER',
            'picked' => 'picked',
            'banned' => 'banned',
            'asT' => '作为 T 方开局',
            'asCT' => '作为 CT 方开局',
            'asKnife' => '作为拼刀选边',
            'knifeSide' => '拼刀选边',
            
            // 语言切换
            'language' => '语言:',
            'chinese' => '中文',
            'english' => 'English'
        ],
        'en' => [
            // General
            'title' => 'CS2 Map Pick & Ban System',
            'save' => 'Save',
            'reset' => 'Reset',
            'submit' => 'Submit',
            'success' => 'Success',
            'error' => 'Error',
            'loading' => 'Loading...',
            
            // Team Form
            'team1' => 'Team 1:',
            'team2' => 'Team 2:',
            'matchFormat' => 'Match Format:',
            'enterTeam1' => 'Enter Team 1 Name',
            'enterTeam2' => 'Enter Team 2 Name',
            'saveTeamNames' => 'Save Team Names',
            'resetTeamNames' => 'Reset Team Names',
            'saveSuccess' => 'Team names saved',
            'saveError' => 'Failed to set team names',
            'enterTeamName' => 'Please enter team names',
            'resetTeamSuccess' => 'Team names reset',
            'resetTeamError' => 'Failed to reset team names',
            
            // BO1 Type
            'bo1Type' => 'BO1 Type:',
            'major' => 'Major',
            'iem' => 'IEM',
            'majorDesc' => 'Team A bans 2, Team B bans 3, Team A bans 1 more',
            'iemDesc' => 'Team A bans 1, Team B bans 2, Team A bans 2, Team B bans 1 more',
            
            // Observer Mode
            'observerMode' => 'Enter Observer Mode',
            'observerOpened' => 'Observer mode opened',
            
            // Map Selection
            'selectMap' => 'Select Map',
            
            // BP Status
            'bpStatus' => 'BP Process Status',
            'currentFormat' => 'Current Format',
            'remainingBans' => 'Remaining Bans',
            'remainingPicks' => 'Remaining Picks',
            'currentPhase' => 'Current Phase',
            'banPhase' => 'Ban Phase',
            'pickPhase' => 'Pick Phase',
            'bpComplete' => 'BP Complete',
            
            // Form
            'team' => 'Team:',
            'action' => 'Action:',
            'pick' => 'Pick',
            'ban' => 'Ban',
            'decider' => 'Decider',
            'oppositeSide' => 'Opposite Side:',
            'noSide' => 'No Side',
            't' => 'T',
            'ct' => 'CT',
            'knife' => 'KNIFE (Knife Round)',
            
            // Buttons
            'submitButton' => 'Submit',
            'resetChoices' => 'Reset Choices',
            'resetAll' => 'Reset All Data',
            'submittedChoices' => 'Submitted BP',
            'edit' => 'Edit',
            'delete' => 'Delete',
            
            // Messages
            'selectMapFirst' => 'Please select a map first',
            'submitSuccess' => 'Submitted successfully',
            'submitError' => 'Failed to submit choice',
            'resetChoicesSuccess' => 'Choices reset',
            'resetChoicesError' => 'Failed to reset choices',
            'resetAllSuccess' => 'All data reset',
            'editModeActive' => 'Edit mode active, modify and resubmit',
            'editSuccess' => 'Edited successfully',
            'editError' => 'Failed to edit',
            'deleteConfirm' => 'Are you sure you want to delete this BP choice?',
            'deleteSuccess' => 'Deleted successfully',
            'deleteError' => 'Failed to delete',
            'mapAlreadySelected' => 'This map has already been selected',
            'invalidAction' => 'Invalid action type',
            'invalidSide' => 'Invalid side selection',
            'databaseError' => 'Database operation failed',
            'serverError' => 'Internal server error',
            'missingParams' => 'Missing required parameters',
            
            // Side Display
            'decider' => 'DECIDER',
            'picked' => 'picked',
            'banned' => 'banned',
            'asT' => 'as T Side',
            'asCT' => 'as CT Side',
            'asKnife' => 'Knife Round',
            'knifeSide' => 'Knife Round',
            
            // Language Switch
            'language' => 'Language:',
            'chinese' => '中文',
            'english' => 'English'
        ]
    ];
    
    return isset($languages[$lang]) ? $languages[$lang] : $languages['zh'];
}
