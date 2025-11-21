<?php
if (session_status() === PHP_SESSION_NONE)
    session_start(); // Đảm bảo session đã start

include __DIR__ . '/../controllers/connect.php';

$currentPage = basename($_SERVER['PHP_SELF']); //  Lấy tên file hiện tại để xác định trang đang xem
?>

<link rel="stylesheet" href="<?= $baseUrl ?>/src/styles/global.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= $baseUrl ?>/index.php" style="margin-right: 70px;">
            <i class="bi-back"></i><span> Kiến thức 4.0</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu bên trái -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'index.php') echo 'active-nav-link'; ?>"
                        href="<?= $baseUrl ?>/index.php">
                        <i class="bi bi-house-door"></i> Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'about.php') echo 'active-nav-link'; ?>"
                        href="<?= $baseUrl ?>/src/views/about/about.php">
                        Giới thiệu
                    </a>
                </li>

                <?php if (isLoggedIn()): ?>
                <?php
                    $loggedInUserId = $_SESSION['user_id'];
                    $userSql = "SELECT username, first_name, last_name, avatar FROM users WHERE id = ? LIMIT 1";
                    $userStmt = mysqli_prepare($conn, $userSql);
                    $loggedInUser = null;

                    if ($userStmt) {
                        mysqli_stmt_bind_param($userStmt, 'i', $loggedInUserId);
                        mysqli_stmt_execute($userStmt);
                        $userResult = mysqli_stmt_get_result($userStmt);
                        $loggedInUser = mysqli_fetch_assoc($userResult);
                        mysqli_stmt_close($userStmt);
                    }

                    $displayName = htmlspecialchars($loggedInUser['username'] ?? '');
                    if (!empty($loggedInUser['first_name']) && !empty($loggedInUser['last_name'])) {
                        $displayName = htmlspecialchars($loggedInUser['first_name']) . ' ' . htmlspecialchars($loggedInUser['last_name']);
                    } elseif (!empty($loggedInUser['first_name'])) {
                        $displayName = htmlspecialchars($loggedInUser['first_name']);
                    } elseif (!empty($loggedInUser['last_name'])) {
                        $displayName = htmlspecialchars($loggedInUser['last_name']);
                    }

                    $avatarPath = $baseUrl . '/src/assets/dist/avatars/' . htmlspecialchars($loggedInUser['avatar'] ?? 'default_avatar.png');
                    ?>

                <!-- Dropdown menu bài viết -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                            <?php if ($currentPage == 'my_posts.php' || $currentPage == 'create_post.php') echo 'active-nav-link'; ?>"
                        href="#" id="navbarDropdownPosts" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-journal-text"></i> Bài viết
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownPosts">
                        <li>
                            <a class="dropdown-item <?php if ($currentPage == 'my_posts.php') echo 'active-dropdown-link'; ?>"
                                href="<?= $baseUrl ?>/src/views/post/my_posts.php">
                                <i class="bi bi-journal-text"></i> Bài đăng của tôi
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php if ($currentPage == 'create_post.php') echo 'active-dropdown-link'; ?>"
                                href="<?= $baseUrl ?>/src/views/post/create_post.php">
                                <i class="bi bi-plus-square"></i> Đăng bài mới
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php if ($currentPage == 'my_saves.php') echo 'active-dropdown-link'; ?>"
                                href="<?= $baseUrl ?>/src/views/bookmarks/my_bookmarks.php">
                                <i class="bi-bookmark"></i> Bài viết đã lưu
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php if ($currentPage == 'read_history.php') echo 'active-dropdown-link'; ?>"
                                href="<?= $baseUrl ?>/src/views/post/read_history.php">
                                <i class="bi bi-clock-history"></i> Lịch sử đọc bài viết
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>

            <!-- Menu bên phải -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if (isLoggedIn()): ?>

                <?php
                    // ====== HÀM LẤY THÔNG BÁO (CHỈ KHAI BÁO 1 LẦN) ======
                    function getLatestNotifications($conn, $receiverId, $limit = 5)
                    {
                        $sql = "
                            SELECT n.*, u.username, u.avatar, p.title
                            FROM notifications n
                            JOIN users u ON n.sender_id = u.id
                            JOIN posts p ON n.post_id = p.id
                            WHERE n.receiver_id = ?
                            ORDER BY n.created_at DESC
                            LIMIT ?
                        ";

                        $notifications = [];
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmt, 'ii', $receiverId, $limit);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $notifications[] = $row;
                            }
                            mysqli_stmt_close($stmt);
                        }
                        return $notifications;
                    }

                    $notifications = getLatestNotifications($conn, $loggedInUserId);
                    ?>

                <!-- Thông báo -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <?php
                            $unseenCount = array_reduce(
                                $notifications,
                                fn($c, $n) => $c + ($n['seen'] == 0 ? 1 : 0),
                                0
                            );
                            if ($unseenCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $unseenCount ?>
                        </span>
                        <?php endif; ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end"
                        style="width: 300px; max-height: 400px; overflow-y: auto;">

                        <?php if (empty($notifications)): ?>
                        <li class="dropdown-item text-muted">Không có thông báo</li>
                        <?php else: ?>
                        <?php foreach ($notifications as $noti): ?>
                        <a href="<?= $baseUrl ?>/src/views/post/post.php?id=<?= $noti['post_id'] ?>&notification_id=<?= $noti['id'] ?>"
                            class="text-decoration-none text-dark">
                            <li class="dropdown-item d-flex gap-2 align-items-start">
                                <img src="<?= $baseUrl ?>/src/assets/dist/avatars/<?= htmlspecialchars($noti['avatar'] ?? 'default_avatar.png') ?>"
                                    class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                                <div style="flex: 1;">
                                    <div>
                                        <strong><?= htmlspecialchars($noti['username']) ?></strong>
                                        <?=
                                                        trim($noti['type']) == 'like' ? 'đã thích bài viết của bạn' :
                                                        (trim($noti['type']) == 'dislike' ? 'không thích bài viết của bạn' :
                                                        (trim($noti['type']) == 'comment' ? 'đã bình luận bài viết của bạn' :
                                                        'có hoạt động mới trên bài viết của bạn'))
                                                    ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($noti['created_at'])) ?>
                                    </small>
                                </div>
                            </li>
                        </a>
                        <?php endforeach; ?>
                        <?php endif; ?>

                    </ul>
                </li>

                <!-- User -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center
                            <?php if ($currentPage == 'profile.php') echo 'active-nav-link'; ?>" href="#"
                        id="navbarDropdownUser" role="button" data-bs-toggle="dropdown">

                        <img src="<?= $avatarPath ?>" class="rounded-circle me-2"
                            style="width: 30px; height: 30px; object-fit: cover;">

                        <?= $displayName ?>
                        <?php if (isAdmin()): ?>
                        <span class="badge bg-danger ms-1">Admin</span>
                        <?php endif; ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if (isAdmin()): ?>
                        <li><a class="dropdown-item" href="<?= $baseUrl ?>/src/views/admin/index.php">
                                <i class="bi bi-gear"></i> Trang Admin</a></li>
                        <?php endif; ?>

                        <li><a class="dropdown-item" href="<?= $baseUrl ?>/src/views/profile/profile.php">
                                <i class="bi bi-person-circle"></i> Thông tin tài khoản</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li><a class="dropdown-item text-danger" href="<?= $baseUrl ?>/src/views/auth/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
                    </ul>
                </li>

                <?php else: ?>

                <li class="nav-item">
                    <a href="<?= $baseUrl ?>/src/views/auth/register.php" class="btn btn-outline-light me-2">
                        Đăng ký
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= $baseUrl ?>/src/views/auth/login.php" class="btn btn-outline-light">
                        Đăng nhập
                    </a>
                </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bubble Messenger mở Facebook cá nhân với hiệu ứng hover -->
<a href="https://m.me/anh.hong.594371" target="_blank" class="chat-bubble">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-messenger"
        viewBox="0 0 16 16">
        <path
            d="M0 7.76C0 3.301 3.493 0 8 0s8 3.301 8 7.76-3.493 7.76-8 7.76c-.81 0-1.586-.107-2.316-.307a.64.64 0 0 0-.427.03l-1.588.702a.64.64 0 0 1-.898-.566l-.044-1.423a.64.64 0 0 0-.215-.456C.956 12.108 0 10.092 0 7.76m5.546-1.459-2.35 3.728c-.225.358.214.761.551.506l2.525-1.916a.48.48 0 0 1 .578-.002l1.869 1.402a1.2 1.2 0 0 0 1.735-.32l2.35-3.728c.226-.358-.214-.761-.551-.506L9.728 7.381a.48.48 0 0 1-.578.002L7.281 5.98a1.2 1.2 0 0 0-1.735.32z" />
    </svg>
    <span class="chat-text">Chat với tôi</span>
</a>

<style>
.chat-bubble {
    position: fixed;
    bottom: 20px;
    right: 20px;
    height: 55px;
    background: #0084ff;
    border-radius: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 18px;
    color: #fff;
    font-size: 22px;
    text-decoration: none;
    z-index: 9999;
    overflow: hidden;
    width: 55px;
    /* ban đầu chỉ hiện icon */
    transition: width 0.3s ease, background 0.2s ease, transform 0.2s ease;
}

/* Text ẩn lúc đầu */
.chat-text {
    font-size: 15px;
    white-space: nowrap;
    opacity: 0;
    transform: translateX(10px);
    transition: 0.15s ease;
}

/* Hiệu ứng hover: mở rộng + hiện chữ */
.chat-bubble:hover {
    width: 160px;
    /* chiều dài khi hover */
    background: #006fe0;
    transform: scale(1.03);
}

.chat-bubble:hover .chat-text {
    opacity: 1;
    transform: translateX(0);
}
</style>