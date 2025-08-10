console.log("say Hello");
document.addEventListener('alpine:init', () => {
    Alpine.data('flash', () => ({
        type: 'notice',
        message: '',
        delay: 3000,
        show: true,
        icon: {
            path: "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
            viewBox: "0 0 24 24"
        },
        init() {
            this.setIcon();
            
            if (this.delay) {
                setTimeout(() => {
                    this.show = false;
                }, this.delay);
            }
        },
        setIcon() {
            const icons = {
                notice: {
                    path: "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
                    viewBox: "0 0 24 24"
                },
                alert: {
                    path: "M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z",
                    viewBox: "0 0 24 24"
                },
                success: {
                    path: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z",
                    viewBox: "0 0 24 24"
                },
                error: {
                    path: "M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z",
                    viewBox: "0 0 24 24"
                }
            };

            this.icon = icons[this.type] || {
                path: "M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9",
                viewBox: "0 0 24 24"
            };
        }
    }));
});