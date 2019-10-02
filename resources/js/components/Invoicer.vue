<script>
    export default {
    	data: function () {
            return {
            	query: '',
                options: [
                    ],
                item: {
                    value: '',
                    text: ''
                }
            }
        },
        
        mounted() {
            console.log('Invoicer mounted.')
        },

        methods: {
            addItem() {
                //console.log("Oh Yeah!!");
                // if (this.timer) {
                //     clearTimeout(this.timer);
                //     this.timer = null;
                // }
                // this.timer = setTimeout(() => {
                //     if (this.search.length > 3) {
                //         console.log("Searching.....")
                //     }
                // }, 1000);
            },

            onSearch(search, loading) {

                //loading(true);
                //this.search(loading, search, this);
                
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(() => {
                    let test = search;
                    if (search.length == 0) {
                        test = this.$refs.test._data._value;
                    }
                    if (test.length > 3) {
                        this.search(loading, search, this);
                    }
                }, 1000);
            },

            search (loading, search, vm) {
                console.log(search);
                console.log(this.$refs.test._data._value);
            }

        }
    }
</script>