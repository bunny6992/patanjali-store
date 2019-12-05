<script>
    export default {
    	data: function () {
            return {
            	route: 'sale',
                file: '',
                bulkUpdate: false
            }
        },
        
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            submit(apiLink) {
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post(apiLink, 
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }

                    ).then(response => {
                        console.log('File Sent!');
                }).catch(error => {
                    if (error.response.status === 422) {
                      this.errors = error.response.data.errors || {};
                    }
                });
            },

            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            },

            getInvoices(getExpenses = false) {

                if (getExpenses) {
                    this.$parent.route = "expenses";
                } else {
                    this.$parent.route = "invoices";
                }
                if (this.$refs.invoicer && this.$parent.route == "expenses") {
                    let route = this.$parent.route;
                    this.$refs.invoicer.resetData();
                    this.$refs.invoicer.getInvoices(route);
                    this.$refs.invoicer.getExpenses();
                }
            },

            getInvoicer() {
                this.route = 'sale';
                if (this.$refs.invoicer) {
                    this.$refs.invoicer.resetData();
                }
                
            }
        }
    }
</script>