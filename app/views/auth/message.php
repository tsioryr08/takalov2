<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages & Communication - Modern Bootstrap Admin</title>
    
    <meta name="description" content="Real-time messaging and communication center with chat interface">
    <meta name="keywords" content="bootstrap, admin, dashboard, messages, chat, communication">
    
    <link rel="icon" type="image/svg+xml" href="/assets/favicon-CvUZKS4z.svg">
    <link rel="icon" type="image/png" href="/assets/favicon-B_cwPWBd.png">
    <link rel="manifest" href="/assets/manifest-DTaoG9pG.json">
    
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script type="module" crossorigin src="/assets/vendor-bootstrap-C9iorZI5.js"></script>
    <script type="module" crossorigin src="/assets/vendor-charts-DGwYAWel.js"></script>
    <script type="module" crossorigin src="/assets/vendor-ui-CflGdlft.js"></script>
    <!-- ON NE CHARGE PAS main-bDXl1YJh.js pour eviter les donnees statiques -->
    <link rel="stylesheet" crossorigin href="/assets/main-CFKPan32.css">

    <?php
    // ============================================================
    // PREPARATION DES DONNeES depuis la base de donnees
    // ============================================================
    $conversationsData = [];
    $currentUserId = $current_user ?? 0;

    if (!empty($messages)) {
        foreach ($messages as $msg) {
            // Determiner l'interlocuteur
            if ($msg['sender_id'] == $currentUserId) {
                $otherId      = $msg['receiver_id'];
                $otherName    = $msg['receiver_prenom'] . ' ' . $msg['receiver_nom'];
                $isSent       = true;
            } else {
                $otherId      = $msg['sender_id'];
                $otherName    = $msg['sender_prenom'] . ' ' . $msg['sender_nom'];
                $isSent       = false;
            }

            // Creer la conversation si inexistante
            if (!isset($conversationsData[$otherId])) {
                $initial = strtoupper(substr($otherName, 0, 1));
                $conversationsData[$otherId] = [
                    'id'              => (int)$otherId,
                    'name'            => $otherName,
                    'avatar'          => 'data:image/svg+xml,' . rawurlencode('<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="16" fill="#6366f1"/><text x="16" y="21" text-anchor="middle" fill="white" font-size="14" font-family="Arial">' . $initial . '</text></svg>'),
                    'type'            => 'User',
                    'online'          => false,
                    'lastMessage'     => '',
                    'lastMessageTime' => '',
                    'lastSeen'        => '',
                    'unread'          => 0,
                    'messages'        => []
                ];
            }

            // Ajouter le message
            $conversationsData[$otherId]['messages'][] = [
                'id'   => (int)$msg['id'],
                'text' => $msg['content'],
                'time' => date('H:i', strtotime($msg['created_at'])),
                'sent' => $isSent,
                'read' => (bool)$msg['is_read']
            ];

            // Mettre à jour le dernier message et l'heure
            $conversationsData[$otherId]['lastMessage']     = substr($msg['content'], 0, 50);
            $conversationsData[$otherId]['lastMessageTime'] = date('H:i', strtotime($msg['created_at']));

            // Compter les non lus (uniquement les messages reçus)
            if (!$isSent && $msg['is_read'] == 0) {
                $conversationsData[$otherId]['unread']++;
            }
        }
    }

    $conversationsList = array_values($conversationsData);

    // Nombre total de non lus pour le badge navbar
    $totalUnread = 0;
    foreach ($conversationsList as $conv) {
        $totalUnread += $conv['unread'];
    }
    ?>
</head>

<body data-page="messages" class="messages-page">
    <div class="admin-app">
        <div class="admin-wrapper" id="admin-wrapper">

            <!-- ============================================================
                 HEADER
                 ============================================================ -->
            <header class="admin-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <!-- Logo -->
                        <a class="navbar-brand d-flex align-items-center" href="./index.html">
                            <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23logoGradient)'/%3e%3cpath%20d='M10%2024V8h2.5l2.5%206.5L17.5%208H20v16h-2V12.5L16.5%2020h-1L14%2012.5V24H10z'%20fill='white'%20font-weight='700'/%3e%3cdefs%3e%3clinearGradient%20id='logoGradient'%20x1='0%25'%20y1='0%25'%20x2='100%25'%20y2='100%25'%3e%3cstop%20offset='0%25'%20style='stop-color:%236366f1;stop-opacity:1'%20/%3e%3cstop%20offset='100%25'%20style='stop-color:%238b5cf6;stop-opacity:1'%20/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e" alt="Logo" height="32" class="d-inline-block align-text-top me-2">
                            <h1 class="h4 mb-0 fw-bold text-primary">Metis</h1>
                        </a>

                        <!-- Sidebar Toggle -->
                        <button class="hamburger-menu" type="button" data-sidebar-toggle aria-label="Toggle sidebar">
                            <i class="bi bi-list"></i>
                        </button>

                        <!-- Search Bar -->
                        <div class="search-container flex-grow-1 mx-4" x-data="searchComponent">
                            <div class="position-relative">
                                <input type="search"
                                       class="form-control"
                                       placeholder="Search... (Ctrl+K)"
                                       x-model="query"
                                       @input="search()"
                                       data-search-input
                                       aria-label="Search">
                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3"></i>
                                <div x-show="results.length > 0"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="position-absolute top-100 start-0 w-100 bg-white border rounded-2 shadow-lg mt-1 z-3">
                                    <template x-for="result in results" :key="result.title">
                                        <a :href="result.url" class="d-block px-3 py-2 text-decoration-none text-dark border-bottom">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-text me-2 text-muted"></i>
                                                <span x-text="result.title"></span>
                                                <small class="ms-auto text-muted" x-text="result.type"></small>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side Icons -->
                        <div class="navbar-nav flex-row">
                            <!-- Theme Toggle -->
                            <div x-data="themeSwitch">
                                <button class="btn btn-outline-secondary me-2"
                                        type="button"
                                        @click="toggle()"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="Toggle theme">
                                    <i class="bi bi-sun-fill" x-show="currentTheme === 'light'"></i>
                                    <i class="bi bi-moon-fill" x-show="currentTheme === 'dark'"></i>
                                </button>
                            </div>

                            <!-- Fullscreen -->
                            <button class="btn btn-outline-secondary me-2"
                                    type="button"
                                    data-fullscreen-toggle
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    title="Toggle fullscreen">
                                <i class="bi bi-arrows-fullscreen icon-hover"></i>
                            </button>

                            <!-- Notifications badge depuis DB -->
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary position-relative"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="bi bi-bell"></i>
                                    <?php if ($totalUnread > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?php echo $totalUnread; ?>
                                    </span>
                                    <?php endif; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><h6 class="dropdown-header">Notifications</h6></li>
                                    <?php if ($totalUnread > 0): ?>
                                    <li><a class="dropdown-item" href="#"><?php echo $totalUnread; ?> nouveau(x) message(s)</a></li>
                                    <?php else: ?>
                                    <li><a class="dropdown-item text-muted" href="#">Aucune notification</a></li>
                                    <?php endif; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-center" href="#">Voir toutes les notifications</a></li>
                                </ul>
                            </div>

                            <!-- User Menu -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary d-flex align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23avatarGradient)'/%3e%3cg%20fill='white'%20opacity='0.9'%3e%3ccircle%20cx='16'%20cy='12'%20r='5'/%3e%3cpath%20d='M16%2018c-5.5%200-10%202.5-10%207v1h20v-1c0-4.5-4.5-7-10-7z'/%3e%3c/g%3e%3ccircle%20cx='16'%20cy='16'%20r='15.5'%20fill='none'%20stroke='rgba(255,255,255,0.2)'%20stroke-width='1'/%3e%3cdefs%3e%3clinearGradient%20id='avatarGradient'%20x1='0%25'%20y1='0%25'%20x2='100%25'%20y2='100%25'%3e%3cstop%20offset='0%25'%20style='stop-color:%236b7280;stop-opacity:1'%20/%3e%3cstop%20offset='100%25'%20style='stop-color:%234b5563;stop-opacity:1'%20/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e"
                                         alt="User Avatar"
                                         width="24"
                                         height="24"
                                         class="rounded-circle me-2">
                                    <span class="d-none d-md-inline"><?php echo htmlspecialchars($user_name ?? 'Utilisateur'); ?></span>
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Deconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- ============================================================
                 SIDEBAR
                 ============================================================ -->
            <aside class="admin-sidebar" id="admin-sidebar">
                <div class="sidebar-content">
                    <nav class="sidebar-nav">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="./index.html">
                                    <i class="bi bi-speedometer2"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./analytics.html">
                                    <i class="bi bi-graph-up"></i>
                                    <span>Analytics</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./users.html">
                                    <i class="bi bi-people"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./products.html">
                                    <i class="bi bi-box"></i>
                                    <span>Products</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./orders.html">
                                    <i class="bi bi-bag-check"></i>
                                    <span>Orders</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./forms.html">
                                    <i class="bi bi-ui-checks"></i>
                                    <span>Forms</span>
                                    <span class="badge bg-success rounded-pill ms-auto">New</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#elementsSubmenu" aria-expanded="false">
                                    <i class="bi bi-puzzle"></i>
                                    <span>Elements</span>
                                    <span class="badge bg-primary rounded-pill ms-2 me-2">New</span>
                                    <i class="bi bi-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="elementsSubmenu">
                                    <ul class="nav nav-submenu">
                                        <li class="nav-item"><a class="nav-link" href="./elements.html"><i class="bi bi-grid"></i><span>Overview</span></a></li>
                                        <li class="nav-item"><a class="nav-link" href="./elements-buttons.html"><i class="bi bi-square"></i><span>Buttons</span></a></li>
                                        <li class="nav-item"><a class="nav-link" href="./elements-alerts.html"><i class="bi bi-exclamation-triangle"></i><span>Alerts</span></a></li>
                                        <li class="nav-item"><a class="nav-link" href="./elements-badges.html"><i class="bi bi-award"></i><span>Badges</span></a></li>
                                        <li class="nav-item"><a class="nav-link" href="./elements-cards.html"><i class="bi bi-card-text"></i><span>Cards</span></a></li>
                                        <li class="nav-item"><a class="nav-link" href="./elements-modals.html"><i class="bi bi-window"></i><span>Modals</span></a></li>
                                        <li class="nav-item"><a class="nav-link" href="./elements-forms.html"><i class="bi bi-ui-checks"></i><span>Forms</span></a></li>
                                        <li class="nav-item"><a class="nav-link" href="./elements-tables.html"><i class="bi bi-table"></i><span>Tables</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./reports.html">
                                    <i class="bi bi-file-earmark-text"></i>
                                    <span>Reports</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./messages.html">
                                    <i class="bi bi-chat-dots"></i>
                                    <span>Messages</span>
                                    <?php if ($totalUnread > 0): ?>
                                    <span class="badge bg-danger rounded-pill ms-auto"><?php echo $totalUnread; ?></span>
                                    <?php else: ?>
                                    <span class="badge bg-primary rounded-pill ms-auto">Active</span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./calendar.html">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>Calendar</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./files.html">
                                    <i class="bi bi-folder2-open"></i>
                                    <span>Files</span>
                                </a>
                            </li>
                            <li class="nav-item mt-3">
                                <small class="text-muted px-3 text-uppercase fw-bold">Admin</small>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./settings.html">
                                    <i class="bi bi-gear"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./security.html">
                                    <i class="bi bi-shield-check"></i>
                                    <span>Security</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./help.html">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Help & Support</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <div class="sidebar-backdrop" aria-hidden="true"></div>

            <!-- ============================================================
                 MAIN CONTENT
                 ============================================================ -->
            <main class="admin-main">
                <div class="container-fluid p-4 p-lg-4">

                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h1 class="h3 mb-0">Messages</h1>
                            <p class="text-muted mb-0">Real-time communication center</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary d-lg-none" id="btnToggleSidebar">
                                <i class="bi bi-list me-2"></i>Conversations
                            </button>
                            <!-- BOUTON RAFRAÎCHIR : recharge la page pour refetcher les donnees DB -->
                            <button type="button" class="btn btn-success" id="btnRefresh">
                                <i class="bi bi-arrow-clockwise me-2" id="refreshIcon"></i>Rafraîchir
                            </button>
                            <!-- BOUTON TOUT LU : appel AJAX pour marquer tout comme lu -->
                            <button type="button" class="btn btn-outline-secondary" id="btnMarkAllRead">
                                <i class="bi bi-check-all me-2"></i>Tout lu
                            </button>
                            <button type="button" class="btn btn-primary" id="btnNewConversation">
                                <i class="bi bi-plus-lg me-2"></i>Nouveau
                            </button>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="messages-container" id="messagesApp">
                        <div class="messages-layout">

                            <!-- Conversations Sidebar -->
                            <div class="messages-sidebar" id="messagesSidebar">
                                <div class="messages-header">
                                    <h5 class="header-title mb-0">Messages</h5>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="search-container flex-grow-1">
                                            <input type="search"
                                                   class="form-control"
                                                   placeholder="Search conversations..."
                                                   id="searchConversations">
                                            <i class="bi bi-search search-icon"></i>
                                        </div>
                                        <button class="btn btn-primary btn-sm" id="btnNewConversationSmall" title="New Message">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Liste generee depuis PHP -->
                                <div class="conversations-list" id="conversationsList">
                                    <?php if (empty($conversationsList)): ?>
                                    <div class="empty-conversations" id="emptyConversations">
                                        <i class="bi bi-chat-dots"></i>
                                        <p>Aucune conversation trouvee</p>
                                    </div>
                                    <?php else: ?>
                                        <?php foreach ($conversationsList as $conv): ?>
                                        <a href="#"
                                           class="conversation-item <?php echo ($conv['unread'] > 0) ? 'unread' : ''; ?>"
                                           data-conv-id="<?php echo (int)$conv['id']; ?>"
                                           onclick="event.preventDefault(); selectConversation(<?php echo (int)$conv['id']; ?>);">
                                            <div class="conversation-avatar">
                                                <img src="<?php echo htmlspecialchars($conv['avatar']); ?>"
                                                     alt="<?php echo htmlspecialchars($conv['name']); ?>">
                                            </div>
                                            <div class="conversation-info">
                                                <div class="conversation-header">
                                                    <h6 class="conversation-name"><?php echo htmlspecialchars($conv['name']); ?></h6>
                                                    <span class="conversation-time"><?php echo htmlspecialchars($conv['lastMessageTime']); ?></span>
                                                </div>
                                                <p class="conversation-preview"><?php echo htmlspecialchars($conv['lastMessage']); ?></p>
                                                <div class="conversation-footer">
                                                    <span class="conversation-type"><?php echo htmlspecialchars($conv['type']); ?></span>
                                                    <?php if ($conv['unread'] > 0): ?>
                                                    <span class="unread-badge"><?php echo $conv['unread']; ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Chat Area -->
                            <div class="chat-area">

                                <!-- Chat actif (cache par defaut, montre quand on selectionne une conversation) -->
                                <div class="active-chat" id="activeChat" style="display: none;">
                                    <!-- Chat Header -->
                                    <div class="chat-header">
                                        <div class="chat-user-info">
                                            <button class="btn btn-link d-lg-none me-2 p-0" id="btnBackToList">
                                                <i class="bi bi-arrow-left fs-5"></i>
                                            </button>
                                            <div class="chat-avatar-container">
                                                <img src="" class="chat-avatar" id="chatAvatar" alt="Contact">
                                            </div>
                                            <div class="chat-details">
                                                <h6 class="chat-name" id="chatName"></h6>
                                                <p class="chat-status text-muted">Hors ligne</p>
                                            </div>
                                        </div>
                                        <div class="chat-actions">
                                            <button class="btn" title="Video Call">
                                                <i class="bi bi-camera-video"></i>
                                            </button>
                                            <button class="btn" title="Voice Call">
                                                <i class="bi bi-telephone"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" data-bs-toggle="dropdown" title="More Options">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-bell-slash me-2"></i>Mute notifications</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-archive me-2"></i>Archive chat</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete chat</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Messages Area -->
                                    <div class="chat-messages" id="chatMessages">
                                        <div class="date-separator">
                                            <span class="date-label">Aujourd'hui</span>
                                        </div>
                                        <!-- Les messages sont injectes ici par JS -->
                                        <div class="message-group" id="messageGroup"></div>
                                    </div>

                                    <!-- Message Input -->
                                    <div class="chat-input">
                                        <div class="input-container">
                                            <div class="input-actions">
                                                <button class="btn" title="Attach file">
                                                    <i class="bi bi-paperclip"></i>
                                                </button>
                                            </div>
                                            <div class="message-input">
                                                <textarea class="form-control"
                                                          placeholder="Type a message..."
                                                          rows="1"
                                                          id="messageInput"
                                                          style="resize: none;"></textarea>
                                            </div>
                                            <div class="input-actions">
                                                <button class="btn" id="btnEmoji" title="Add emoji">
                                                    <i class="bi bi-emoji-smile"></i>
                                                </button>
                                                <button class="btn btn-primary" id="btnSend" title="Send message" disabled>
                                                    <i class="bi bi-send"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Emoji Picker -->
                                        <div class="emoji-picker" id="emojiPicker" style="display: none;">
                                            <div class="emoji-grid" id="emojiGrid"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Empty Chat State (montre par defaut) -->
                                <div class="empty-chat" id="emptyChat">
                                    <div class="empty-icon">
                                        <i class="bi bi-chat-dots"></i>
                                    </div>
                                    <h5 class="empty-text">Select a conversation to start messaging</h5>
                                    <p class="text-muted mb-4">Choose from your existing conversations or start a new one</p>
                                    <button class="btn btn-primary" id="btnNewConversationEmpty">
                                        <i class="bi bi-plus-lg me-2"></i>Start New Conversation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="admin-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0 text-muted">© 2025 Modern Bootstrap Admin Template</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-0 text-muted">Built with Bootstrap 5.3.8</p>
                        </div>
                    </div>
                </div>
            </footer>

        </div><!-- /.admin-wrapper -->
    </div>

    <!-- ============================================================
         SCRIPT PRINCIPAL — Vanille JS, pas d'Alpine pour cette page
         On charge Alpine juste pour les autres composants (search, theme)
         mais messagesComponent est gere en pur JS vanilla
         ============================================================ -->
    <script type="module">
    // On importe Alpine pour les autres composants de la page (search, themeSwitch)
    // mais on ne definit PAS messagesComponent via Alpine
    import Alpine from '/assets/vendor-ui-CflGdlft.js';

    // Minimal searchComponent pour la barre de recherche du header
    Alpine.data('searchComponent', () => ({
        query: '',
        results: [],
        search() {
            // Implemente ta logique de recherche ici si necessaire
            this.results = [];
        }
    }));

    // Minimal themeSwitch avec localStorage pour persister le theme
    Alpine.data('themeSwitch', () => ({
        currentTheme: localStorage.getItem('theme') || 'dark', // Mode sombre par defaut
        init() {
            // Appliquer le theme au demarrage
            document.documentElement.setAttribute('data-bs-theme', this.currentTheme);
        },
        toggle() {
            this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-bs-theme', this.currentTheme);
            localStorage.setItem('theme', this.currentTheme);
        }
    }));

    Alpine.start();
    </script>

    <!-- Donnees PHP injectees en JSON pour le JS vanilla -->
    <script>
    window.CONVERSATIONS = <?php echo json_encode($conversationsList); ?>;
    window.CURRENT_USER   = <?php echo json_encode($current_user ?? 0); ?>;
    </script>

    <!-- Logique messaging en vanilla JS -->
    <script>
    (function() {
        'use strict';

        // ============================================================
        // eTAT
        // ============================================================
        let conversations      = window.CONVERSATIONS || [];
        let selectedConvId     = null;
        let sidebarVisible     = false;

        const emojis = ['😀','😃','😄','😁','😊','😍','🥰','😘','👍','👏','🎉','❤️','🔥','💯','😂','🤔'];

        // ============================================================
        // ReCUPeRATION DES eLeMENTS DOM
        // ============================================================
        const conversationsList   = document.getElementById('conversationsList');
        const searchInput         = document.getElementById('searchConversations');
        const activeChat          = document.getElementById('activeChat');
        const emptyChat           = document.getElementById('emptyChat');
        const chatName            = document.getElementById('chatName');
        const chatAvatar          = document.getElementById('chatAvatar');
        const messageGroup        = document.getElementById('messageGroup');
        const chatMessages        = document.getElementById('chatMessages');
        const messageInput        = document.getElementById('messageInput');
        const btnSend             = document.getElementById('btnSend');
        const btnEmoji            = document.getElementById('btnEmoji');
        const emojiPicker         = document.getElementById('emojiPicker');
        const emojiGrid           = document.getElementById('emojiGrid');
        const btnRefresh          = document.getElementById('btnRefresh');
        const refreshIcon         = document.getElementById('refreshIcon');
        const btnMarkAllRead      = document.getElementById('btnMarkAllRead');
        const btnBackToList       = document.getElementById('btnBackToList');
        const messagesSidebar     = document.getElementById('messagesSidebar');
        const btnToggleSidebar    = document.getElementById('btnToggleSidebar');

        // ============================================================
        // INIT
        // ============================================================
        function init() {
            renderEmojis();
            bindEvents();

            // Sur desktop, selectionner automatiquement la premiere conversation
            if (window.innerWidth >= 992 && conversations.length > 0) {
                selectConversation(conversations[0].id);
            }
        }

        // ============================================================
        // RENDER EMOJIS
        // ============================================================
        function renderEmojis() {
            emojiGrid.innerHTML = '';
            emojis.forEach(e => {
                const btn = document.createElement('button');
                btn.className = 'emoji-btn';
                btn.textContent = e;
                btn.onclick = () => addEmoji(e);
                emojiGrid.appendChild(btn);
            });
        }

        // ============================================================
        // BIND EVENTS
        // ============================================================
        function bindEvents() {
            // Recherche dans les conversations
            searchInput.addEventListener('input', filterConversations);

            // Input message
            messageInput.addEventListener('input', function() {
                btnSend.disabled = !this.value.trim();
                autoResize(this);
            });

            // Enter pour envoyer
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Bouton envoyer
            btnSend.addEventListener('click', sendMessage);

            // Emoji
            btnEmoji.addEventListener('click', function(e) {
                e.stopPropagation();
                emojiPicker.style.display = (emojiPicker.style.display === 'none') ? 'block' : 'none';
            });

            // Fermer emoji picker en cliquant ailleurs
            document.addEventListener('click', function(e) {
                if (!emojiPicker.contains(e.target) && e.target !== btnEmoji) {
                    emojiPicker.style.display = 'none';
                }
            });

            // Bouton Rafraîchir
            btnRefresh.addEventListener('click', refreshMessages);

            // Bouton Tout lu
            btnMarkAllRead.addEventListener('click', markAllRead);

            // Bouton retour liste (mobile)
            btnBackToList.addEventListener('click', function() {
                messagesSidebar.classList.add('mobile-show');
                sidebarVisible = true;
            });

            // Bouton toggle sidebar (mobile)
            if (btnToggleSidebar) {
                btnToggleSidebar.addEventListener('click', function() {
                    sidebarVisible = !sidebarVisible;
                    messagesSidebar.classList.toggle('mobile-show', sidebarVisible);
                });
            }
        }

        // ============================================================
        // FILTRER CONVERSATIONS (recherche)
        // ============================================================
        function filterConversations() {
            const query = searchInput.value.toLowerCase().trim();
            const items = conversationsList.querySelectorAll('.conversation-item');

            items.forEach(item => {
                const name    = item.querySelector('.conversation-name').textContent.toLowerCase();
                const preview = item.querySelector('.conversation-preview').textContent.toLowerCase();

                if (!query || name.includes(query) || preview.includes(query)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // ============================================================
        // SeLECTIONNER UNE CONVERSATION
        // ============================================================
        window.selectConversation = function(convId) {
            const conv = conversations.find(c => c.id === convId);
            if (!conv) return;

            selectedConvId = convId;

            // Mettre à jour l'highlight dans la liste
            document.querySelectorAll('.conversation-item').forEach(el => el.classList.remove('active'));
            const activeItem = document.querySelector(`[data-conv-id="${convId}"]`);
            if (activeItem) {
                activeItem.classList.add('active');
                // Marquer comme lu localement + supprimer le badge
                activeItem.classList.remove('unread');
                const badge = activeItem.querySelector('.unread-badge');
                if (badge) badge.remove();
            }

            // Marquer comme lu côte serveur (AJAX)
            markConversationRead(convId);

            // Mettre à jour l'etat local
            conv.unread = 0;

            // Afficher le chat
            chatName.textContent   = conv.name;
            chatAvatar.src         = conv.avatar;
            chatAvatar.alt         = conv.name;

            // Render les messages
            renderMessages(conv.messages);

            // Afficher le chat, cacher l'etat vide
            activeChat.style.display = '';
            emptyChat.style.display  = 'none';

            // Sur mobile, fermer la sidebar
            if (window.innerWidth < 992) {
                messagesSidebar.classList.remove('mobile-show');
                sidebarVisible = false;
            }

            // Scroll vers le bas
            setTimeout(scrollToBottom, 50);
        };

        // ============================================================
        // RENDER MESSAGES
        // ============================================================
        function renderMessages(messages) {
            messageGroup.innerHTML = '';

            messages.forEach(msg => {
                const div = document.createElement('div');
                div.className = 'message' + (msg.sent ? ' own-message' : '');

                let avatarHtml = '';
                if (!msg.sent) {
                    const conv = conversations.find(c => c.id === selectedConvId);
                    avatarHtml = `<img src="${conv ? conv.avatar : ''}" class="message-avatar" alt="${conv ? conv.name : ''}">`;
                }

                let statusHtml = '';
                if (msg.sent) {
                    statusHtml = `<span class="message-status">
                        <i class="bi ${msg.read ? 'bi-check-all' : 'bi-check'}"></i>
                    </span>`;
                } else {
                    // Message reçu - afficher badge "Non lu" si pas encore lu
                    if (!msg.read) {
                        statusHtml = `<span class="badge bg-warning text-dark">Non lu</span>`;
                    }
                }

                div.innerHTML = `
                    ${avatarHtml}
                    <div class="message-bubble">
                        <div class="message-content">
                            <p>${escapeHtml(msg.text)}</p>
                        </div>
                        <div class="message-info">
                            <span class="message-time">${escapeHtml(msg.time)}</span>
                            ${statusHtml}
                        </div>
                    </div>
                `;

                messageGroup.appendChild(div);
            });
        }

        // ============================================================
        // ENVOYER UN MESSAGE (AJAX vers /messages/send)
        // ============================================================
        function sendMessage() {
            const content = messageInput.value.trim();
            if (!content || !selectedConvId) return;

            // Desactiver le bouton pendant l'envoi
            btnSend.disabled = true;

            fetch('/messages/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                body: 'receiver_id=' + selectedConvId + '&content=' + encodeURIComponent(content)
            })
            .then(r => r.json())
            .then(data => {
                if (data.ok) {
                    const now = new Date();
                    const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    const newMsg = {
                        id:   data.id || Date.now(),
                        text: content,
                        time: time,
                        sent: true,
                        read: false
                    };

                    // Ajouter au state local
                    const conv = conversations.find(c => c.id === selectedConvId);
                    if (conv) {
                        conv.messages.push(newMsg);
                        conv.lastMessage     = content.substring(0, 50);
                        conv.lastMessageTime = time;

                        // Mettre à jour le preview dans la liste
                        const item = document.querySelector(`[data-conv-id="${selectedConvId}"]`);
                        if (item) {
                            item.querySelector('.conversation-preview').textContent = conv.lastMessage;
                            item.querySelector('.conversation-time').textContent   = conv.lastMessageTime;
                        }
                    }

                    // Re-render les messages
                    renderMessages(conv.messages);

                    // Vider l'input
                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    btnSend.disabled = true;

                    scrollToBottom();
                } else {
                    console.error('Erreur envoi :', data);
                    btnSend.disabled = false;
                }
            })
            .catch(err => {
                console.error('Erreur reseau :', err);
                btnSend.disabled = false;
            });
        }

        // ============================================================
        // MARQUER UNE CONVERSATION COMME LUE (AJAX vers /messages/read)
        // ============================================================
        function markConversationRead(convId) {
            fetch('/messages/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                body: 'conversation_id=' + convId
            })
            .then(r => r.json())
            .then(data => {
                if (!data.ok) console.warn('Marquer lu echoue :', data);
            })
            .catch(err => console.error('Erreur marquer lu :', err));
        }

        // ============================================================
        // MARQUER TOUT COMME LU (AJAX vers /messages/read-all)
        // ============================================================
        function markAllRead() {
            fetch('/messages/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                body: ''
            })
            .then(r => r.json())
            .then(data => {
                if (data.ok) {
                    // Mettre à jour l'UI localement
                    conversations.forEach(conv => { conv.unread = 0; });
                    document.querySelectorAll('.conversation-item').forEach(item => {
                        item.classList.remove('unread');
                        const badge = item.querySelector('.unread-badge');
                        if (badge) badge.remove();
                    });
                    // Rafraîchir pour avoir les donnees fraîches
                    location.reload();
                } else {
                    console.warn('Tout lu echoue :', data);
                }
            })
            .catch(err => console.error('Erreur tout lu :', err));
        }

        // ============================================================
        // RAFRAÎCHIR (recharge la page = re-fetch depuis la DB)
        // ============================================================
        function refreshMessages() {
            // Animation de rotation sur l'icône
            refreshIcon.classList.add('spin');
            btnRefresh.disabled = true;

            // Petit delai pour que l'animation soit visible, puis reload
            setTimeout(() => {
                location.reload();
            }, 400);
        }

        // ============================================================
        // UTILITAIRES
        // ============================================================
        function scrollToBottom() {
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }

        function autoResize(el) {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        }

        function addEmoji(emoji) {
            messageInput.value += emoji;
            messageInput.dispatchEvent(new Event('input'));
            emojiPicker.style.display = 'none';
            messageInput.focus();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(text));
            return div.innerHTML;
        }

        // ============================================================
        // STYLE INLINE pour l'animation du refresh
        // ============================================================
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            #refreshIcon.spin {
                display: inline-block;
                animation: spin 0.4s linear;
            }
        `;
        document.head.appendChild(style);

        // ============================================================
        // START
        // ============================================================
        document.addEventListener('DOMContentLoaded', init);

    })();
    </script>
</body>
</html>