var crowpack = {
    currentpage     : '',
    currentsubpage  : '',
    subpages        : [''],
    pageloaded() {
        // register subpages
        var subpgels = $(this.currentpage).children('.subpage');
        var subs = [];
        $.each(subpgels,function(i,obj) {
            subs.push($(obj).attr('id'));
        })
        this.subpages = subs;
    },
    showpage(p) {
        $.each(initjson.viewids,function(i,v) {
            $(v).hide();
        });
        $(p).show();
        this.currentpage = p;
        this.pageloaded();
    },
    showsubpage(sp) {
        $.each(this.subpages,function(i,v) {
            $('#'+v).hide();
        });
        $(this.currentpage+sp).show();
        this.currentsubpage = sp;
    }
}

