<script>
    export default {
    	data: function () {
            return {
            	route: 'sale',
                file: '',
                bulkUpdate: false,
                newProducts: [],
                allItems: [],
                columns: [
                    'Barcode',
                    'Style Name',
                    'FOR',
                    'Color',
                    'Size',
                    'QTY',
                    'Cost Price',
                    'MRP',
                ],
                options:{
                    sortable: ['Style Name', 'FOR', 'Barcode', 'Color', 'Size', 'Cost Price', 'MRP'],
                    filterable: false,
                },
                item_columns: [
                    'product_id',
                    'for',
                    'name',
                    'barcode',
                    'color',
                    'size',
                    'qty',
                    'mrp'
                ],
                table_options:{
                    sortable: true,
                    filterable: true,
                    headings: {
                        name: 'Style Name',
                        qty: 'Quantity In Stock'
                    },
                },
            }
        },
        
        mounted() {
            // axios.get(`api/get-all-items`)
            // .then(response => {
            //     this.allItems = response.data;                
            // }).catch(error => {
            //     if (error.response.status === 422) {
            //       this.errors = error.response.data.errors || {};
            //     }
            // });
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
            reader.onload = (event) => {
                var data = event.target.result;
                var workbook = XLSX.read(data, {
                    type: 'binary'
                });
                workbook.SheetNames.forEach((sheetName) => {

                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    var json_object = JSON.stringify(XL_row_object);
                    this.newProducts = JSON.parse(json_object);
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

            getInvoices(getExpenses) {

                if (getExpenses == 'true') {
                    this.route = "expenses";
                } else {
                    this.route = "invoices";
                }
                if (this.$refs.invoicer && this.route == "expenses") {
                    this.$refs.invoicer.resetData();
                    this.$refs.invoicer.getInvoices(this.route);
                    this.$refs.invoicer.getExpenses();
                } else if (this.$refs.invoicer && this.route == "invoices") {
                    this.$refs.invoicer.getInvoices(this.route);
                }
            },

            getInvoicer() {
                this.route = 'sale';
                if (this.$refs.invoicer) {
                    this.$refs.invoicer.resetData();
                }
                
            },

            importNewProducts() {
                axios.post("api/bulk-add-products", this.newProducts)
                .then(response => {
                    console.log("DONE!!")
                    
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        }
    }
</script>