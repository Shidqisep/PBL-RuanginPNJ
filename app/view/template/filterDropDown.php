<?php 
// components/FilterDropdown.php
// Menggunakan Vanilla JS + Class/ID untuk state

$filter_id = $filter_id ?? 'default_filter'; // e.g., 'jenis_anggota'
$label = $label ?? 'Pilih Filter';           
$options = $options ?? [];                   
$current_values = $_GET[$filter_id] ?? ''; 

// Array nilai saat ini untuk menandai checkbox
$current_array = array_filter(explode(',', $current_values));
?>

<div class="relative filter-dropdown-container" 
     data-filter-id="<?= $filter_id ?>"
     data-default-label="<?= $label ?>">

    <button onclick="toggleDropdown('<?= $filter_id ?>_menu')" type="button" 
        class="filter-dropdown-toggle flex items-center gap-2 px-4 py-2 border border-dark-overlay5 rounded-lg text-sm text-blue-overlay bg-white hover:bg-dark-overlay1 transition min-w-[10rem] focus:outline-none focus:ring-2 focus:ring-blue-500"
        aria-haspopup="true" aria-expanded="false">
        
        <span class="font-medium" id="<?= $filter_id ?>_label">
            <?= $label ?> 
        </span>
        
        <div class="ml-auto filter-dropdown-arrow transition-transform duration-300">
            <?= icon('arrowDown', 'w-5 h-5') ?>
        </div>
    </button>

    <div id="<?= $filter_id ?>_menu" 
         class="hidden absolute z-20 mt-2 w-56 bg-white border border-dark-overlay5 rounded-lg shadow-xl origin-top-left max-h-60 overflow-y-auto filter-dropdown-menu">
        <ul class="py-1">
            <?php foreach ($options as $option_label => $option_value): ?>
                <?php 
                    // Membuat ID yang bersih untuk checkbox
                    $clean_id = $filter_id . '_' . strtolower(str_replace([' ', '&'], ['_', '_'], $option_value));
                ?>
                <li class="px-4 py-2 hover:bg-dark-overlay1 transition">
                    <label for="<?= $clean_id ?>" 
                           class="flex items-center cursor-pointer space-x-2 text-sm text-dark-overlay7">
                        
                        <input type="checkbox"
                               id="<?= $clean_id ?>"
                               value="<?= htmlspecialchars($option_value) ?>"
                               onchange="toggleFilter('<?= $filter_id ?>', '<?= htmlspecialchars($option_value) ?>', '<?= $filter_id ?>_label', '<?= $label ?>')"
                               <?= in_array($option_value, $current_array) ? 'checked' : '' ?>
                               class="h-4 w-4 text-blue-overlay border-dark-overlay5 rounded focus:ring-blue-overlay">
                        
                        <span><?= $option_label ?></span>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <input type="hidden" name="<?= $filter_id ?>" id="<?= $filter_id ?>" value="<?= htmlspecialchars($current_values) ?>">

</div>