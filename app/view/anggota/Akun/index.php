<!-- Main Content -->
<main class="container mx-auto md:px-6 lg:px-6 px-4 py-8 max-w-2xl">
    <h2 class="text-3xl font-bold text-dark-overlay mb-10 text-center">Akun</h2>

    <!-- Avatar Section -->
    <div class="flex justify-center mb-8 relative">
        <div class="flex flex-col items-center">
            <div class="relative">
                <!-- Avatar Display -->
                <div id="avatarPreview" class="w-40 h-40 bg-white1 rounded-full flex items-center justify-center shadow-lg overflow-hidden border-4 border-white1">
                    <?php if (!empty($user['profile_photo'])): ?>
                        <?php if (str_starts_with($user['profile_photo'], '/img/avatars/')): ?>
                            <img src="<?= htmlspecialchars($user['profile_photo']) ?>" alt="avatar" class="w-full h-full object-cover">
                        <?php else: ?>
                            <img src="<?= htmlspecialchars($user['profile_photo']) ?>" alt="profile" class="w-full h-full object-cover">
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Default Avatar -->
                        <div class="w-full h-full flex items-center justify-center">
                            <?= icon('user', 'w-full h-full text-dark-overlay6') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Violation Count Badge -->
                <div class="absolute bottom-4 right-0 text-xs mt-4 bg-yellow1/50 text-red1 px-2 py-1 rounded-lg shadow-md">
                    <p class="text-xs">Pelanggaran: <span class="font-semibold"><?= $suspend_count ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Badge/Label Ganti Avatar -->
    <div class="text-center mb-10">
        <button type="button" 
                onclick="showAvatarOptions()"
                class="text-blue-overlay hover:text-blue-700 text-sm font-medium transition hover:cursor-pointer">
            <?= icon('sync', 'w-4 h-4 inline-block mr-1') ?>
            Ganti Avatar
        </button>
    </div>

    <!-- User Info -->
    <div class="space-y-6 mb-10">
        <div>
            <label class="block text-sm font-medium text-dark-overlay7 mb-1">Nama</label>
            <div class="border-b border-dark-overlay4 pb-2">
                <p class="text-dark-overlay font-medium"><?= $user['username'] ?></p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-dark-overlay7 mb-1">Email</label>
            <div class="border-b border-dark-overlay4 pb-2">
                <p class="text-dark-overlay"><?= $user['email']?></p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-dark-overlay7 mb-1">Jurusan</label>
            <div class="border-b border-dark-overlay4 pb-2">
                <p class="text-dark-overlay"><?= $user['jurusan_unit']?></p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-dark-overlay7 mb-1">Prodi</label>
            <div class="border-b border-dark-overlay4 pb-2">
                <p class="text-dark-overlay"><?= $user['prodi']?></p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="grid grid-cols-2 gap-4 mb-4">
        <a href="/Akun/gantiPassword" 
           class="bg-blue-overlay text-white1 hover:bg-blue-700 text-center py-3 rounded-lg font-semibold transition duration-200">
            Ganti Password
        </a>
        <a href="#" onclick="konfirmasiLogout()"
            class="block w-full bg-red1 text-white1 hover:bg-red-700 text-center py-3 rounded-lg font-semibold transition duration-200">
            Logout
        </a>
    </div>

    <!-- Hidden Form untuk Upload -->
    <form id="profilePhotoForm" action="/Akun/updateProfilePhoto" method="post" enctype="multipart/form-data" style="display: none;">
        <input type="file" id="profileFileInput" name="profile_file" accept="image/*">
        <input type="hidden" id="selectedAvatarInput" name="selected_avatar" value="">
    </form>

</main> 

<script src="/js/profilePhoto.js"></script>