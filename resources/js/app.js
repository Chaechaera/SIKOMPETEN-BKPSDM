import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Recommended way, to include only the icons you need.
import { createIcons, ArrowUpNarrowWide, ArrowDownWideNarrow, ChevronDown, ChevronUp, Search, Building2, Mail, IdCard, UserPen, LogOut, FileText, Calendar, Users, Shield, Clock, Award } from 'lucide';

// Jalankan setelah halaman siap
document.addEventListener('DOMContentLoaded', () => {
    createIcons({
        icons: {
            ArrowUpNarrowWide,
            ArrowDownWideNarrow,
            ChevronDown,
            ChevronUp,
            Search,
            Building2,
            Mail,
            IdCard,
            UserPen,
            LogOut,
            FileText,
            Calendar,
            Users,
            Shield,
            Clock,
            Award
        }
    });
});