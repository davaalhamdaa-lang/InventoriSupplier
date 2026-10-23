import { 
    getIcons, 
    Cube, 
    GridAlt, 
    Category, 
    Package, 
    Buildings, 
    Transfer, 
    Printer, 
    Group, 
    LogOutCircle 
} from '@boxicons/js';

// Memastikan DOM siap sebelum merender ikon
document.addEventListener('DOMContentLoaded', () => {
    getIcons({
        icons: {
            Cube,
            GridAlt,
            Category,
            Package,
            Buildings,
            Transfer,
            Printer,
            Group,
            LogOutCircle
        }
    });
});