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

            myFunction(evt){
            var selectedFile = evt.target.files[0];
            var reader = new FileReader();
            reader.onload = function(event) {
                var data = event.target.result;
                var workbook = XLSX.read(data, {
                    type: 'binary'
                });
                workbook.SheetNames.forEach(function(sheetName) {

                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    var json_object = JSON.stringify(XL_row_object);
                    document.getElementById("jsonObject").innerHTML = json_object;

                })
            };

            reader.onerror = function(event) {
                console.error("File could not be read! Code " + event.target.error.code);
            };

            reader.readAsBinaryString(selectedFile);
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