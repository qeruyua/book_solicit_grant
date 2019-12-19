var bookinfo=new Vue({
    el:'#app',
    data:{
        messages:[]
    },
    mounted(){
        this.getinfo();
    },
    methods:{
        getinfo(){
            var self=this;
            reqwest({
                url: ' http://127.0.0.1/ruangong/osiris/controller/admin/showgrant.php'
                , type: 'json'
                , method: 'get'
                , contentType: 'application/json'
                , error: function (err) {
                    console.log(this.url + "请求失败")
                }
                , success: function (resp) {
                    self.messages = resp;
                    console.log(self.messages)
                }
            })
        },
        del(id) {
            alert(id);
            let self = this;
            reqwest({
                url: ' http://127.0.0.1/ruangong/osiris/controller/admin/delgrant.php?bookid='+id
                , type: 'text'
                , method: 'post'
                , data: {
                    id: id,
                }
                , error: function (err) {
                    alert(this.url + "请求失败")
                }
                , success: function (resp) {
                    self.messages = resp;
                    alert(self.messages)
                }
            })
        },
    },

});
