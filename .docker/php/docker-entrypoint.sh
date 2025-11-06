# #!/bin/sh
# set -e

# echo "Menunggu database siap..."
# sleep 3  # tunggu 5 detik biar MySQL benar-benar jalan, bisa pakai wait-for-it juga

# echo "Menjalankan migrasi Phinx..."
# vendor/bin/phinx migrate -e development || echo "Migrasi gagal"
# vendor/bin/phinx seed:run

# echo "Menjalankan server Apache..."
# exec "$@"
