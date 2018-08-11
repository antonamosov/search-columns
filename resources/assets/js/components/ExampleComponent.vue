<template>
    <div class="container">
        <div class="header row">
            <h1>Customize Columns on Search Results</h1>
        </div>
        <div class="row column-card">
            <div class="col-md-5">
                <h2>Custom Columns:</h2>
                <div class="left-column">
                    <div
                            class="custom-field-row row"
                            v-for="column in customColumns"
                    >
                        <div class="custom-field-name custom-field col-md-6">{{ column }}</div>
                        <div
                                class="custom-field-up custom-field col-md-1"
                                @click="upColumn(column)"
                        ><i class="fa fa-chevron-up"></i></div>
                        <div
                                class="custom-field-down custom-field col-md-1"
                                @click="downColumn(column)"
                        ><i class="fa fa-chevron-down"></i></div>
                        <div
                                class="custom-field-cancel custom-field col-md-1"
                                @click="cancelColumn(column)"
                        ><i class="fa fa-times"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <div
                        class="center-column"
                        @click="moveColumns"
                >
                    <i class="fa fa-chevron-left link"></i>
                </div>
            </div>
            <div class="col-md-6">
                <h2>Available Fields:</h2>
                <div class="right-column">
                    <div
                            class="field"
                            :class="{ 'field-selected' : checkColumnSelected(column) }"
                            v-for="column in availableColumns"
                            @click="selectColumn(column)"
                            @dblclick="moveColumn(column)"
                    >{{ column }}</div>
                </div>
            </div>
        </div>
        <div class="row m-1">
            <a
                    class="btn btn-sm btn-success border m-1"
                    @click="search()"
            >Search</a>
            <a
                    class="btn btn-sm btn-default border m-1"
                    @click="resetFilters()"
            >Reset Search</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                availableColumns: [
                    'id',
                    'email',
                    'password',
                ],
                customColumns: [],
                selectedColumns: [],
            }
        },

        mounted() {
            this.fetchColumns();
        },

        methods : {
            fetchColumns() {
                axios.get('/api/search/columns')
                    .then(response => {
                        this.availableColumns = response.data.availableColumns;
                        this.customColumns = response.data.customColumns;
                    });
            },

            checkColumnSelected(column) {
                const index = this.selectedColumns.findIndex(item => item === column);

                return index !== -1;
            },

            checkColumnMoved(column) {
                const index = this.customColumns.findIndex(item => item === column);

                return index !== -1;
            },

            selectColumn(column) {
                if (! this.checkColumnSelected(column)) {
                    this.selectedColumns.push(column);
                }
            },

            moveColumn(column) {
                if (! this.checkColumnMoved(column)) {
                    this.customColumns.push(column);
                }
                const index = this.availableColumns.findIndex(item => item === column);
                this.availableColumns.splice(index, 1)
            },

            moveColumns() {
                this.selectedColumns.forEach(value => {
                    this.moveColumn(value);
                });
                this.selectedColumns = [];
            },

            cancelColumn(column) {
                this.availableColumns.push(column);
                const index = this.customColumns.findIndex(item => item === column);
                this.customColumns.splice(index, 1);
            },

            resetFilters() {
                this.selectedColumns = [];
                this.fetchColumns();
            },

            downColumn(bottomColumn) {
                const bottomIndex = this.customColumns.findIndex(item => item === bottomColumn);
                const topIndex = bottomIndex + 1;
                if (topIndex > this.customColumns.length) {
                    return;
                }
                this.customColumns.splice(bottomIndex, 1);
                this.customColumns.splice(topIndex, 0, bottomColumn);
            },

            upColumn(topColumn) {
                const topIndex = this.customColumns.findIndex(item => item === topColumn);
                const bottomIndex = topIndex - 1;
                if (bottomIndex < 0) {
                    return;
                }
                this.customColumns.splice(topIndex, 1);
                this.customColumns.splice(bottomIndex, 0, topColumn);
            },

            search() {
                axios.post('/api/search/columns', {
                    customColumns : this.customColumns,
                })
                    .then(response => {
                        console.log('ok');
                    });
            }
        },


    }
</script>

<style>
    div.left-column {
        border: 1px solid grey;
        background: #e6e6e6;
        min-height: 500px;
        text-align: left;
        padding : 10px;
    }
    div.center-column {
        text-align: center;
        min-height: 500px;
        padding-top: 250px;
    }
    i.link {
        cursor: pointer;
    }
    div.right-column {
        border: 1px solid grey;
        background: #e6e6e6;
        min-height: 500px;
        text-align: left;
        padding : 10px;
    }
    div.column-card {

    }
    div.field {
        cursor: pointer;
        margin-left: 10px;
    }
    div.field-selected {
        background: #d6d6d6;
    }
    div.custom-field-row {
        margin-left: 10px;
    }

    div.custom-field-name {
        border: 1px solid #d6d6d6;
        cursor: not-allowed;
        border-radius: 5px;
    }
    div.custom-field-up {
        cursor: pointer;
    }
    div.custom-field-down {
        cursor: pointer;
    }
    div.custom-field-cancel {
        cursor: pointer;
    }
</style>