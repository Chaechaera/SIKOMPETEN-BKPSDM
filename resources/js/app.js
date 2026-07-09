import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Recommended way, to include only the icons you need.
import { createIcons, ArrowUpNarrowWide, ArrowDownWideNarrow, ChevronDown, ChevronUp, ChevronLeft, ChevronRight, Search, Building2, 
        Mail, IdCard, UserPen, LogOut, FileText, Calendar, Users, Shield, Clock, Award, Archive, SquarePen, Trash2, X, ChessQueen, ChessRook, 
        ChessPawn, LayoutGrid, ClipboardList, ClipboardPen, Settings, Folder, ChartColumnBig, Info, ListIndentIncrease, 
        ListIndentDecrease, ListSortDescending, ListSortAscending, RotateCcw, Folders } from 'lucide';

// Jalankan setelah halaman siap
document.addEventListener('DOMContentLoaded', () => {
    createIcons({
        icons: {
            ArrowUpNarrowWide,
            ArrowDownWideNarrow,
            ChevronDown,
            ChevronUp,
            ChevronLeft,
            ChevronRight,
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
            Award,
            Archive,
            SquarePen,
            Trash2,
            X,
            ChessQueen,
            ChessRook,
            ChessPawn,
            LayoutGrid,
            ClipboardList,
            ClipboardPen,
            Settings,
            Folder,
            Folders,
            ChartColumnBig,
            Info,
            ListIndentIncrease,
            ListIndentDecrease,
            ListSortDescending,
            ListSortAscending,
            RotateCcw
        }
    });
});