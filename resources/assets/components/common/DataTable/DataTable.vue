<template>
  <div class="container">
    <div v-if="rows.length > 0" class="panel panel-default">
      <div class="panel-heading">
        <h4 class="pull-left"> {{ selectedItems.length > 0 ? `${selectedItems.length} selected` : title }} </h4>
        <div class="action-block">
          <slot name="actions" :items="selectedItems" :enablity="actionsEnablity"></slot>
        </div>
      </div>
      <div class="table-responsive">
      <table class="table">
        <thead>
          <tr @click="onSort">
          <slot></slot>
          </tr>
        </thead>
        <tbody>
          <slot name="body" v-for="row in rows" :item="row"></slot>
        </tbody>
      </table>
      </div>
    </div>
    <template v-if="pages > 1">
      <one-part-paginator v-if="pages <= maxPageWidth" :page="page" :pages="pages" @change="onPageChange"/>
      <multi-part-paginator v-else :page="page" :pages="pages" @change="onPageChange"/>
    </template>
  </div>
</template>

<script>
  import OnePartPaginator from './OnePartPaginator.vue';
  import MultiPartPaginator from './MultiPartPaginator.vue';

  export default {
    props: {
      getData: {
        type: Function,
      },
      height: {
        type: String,
        default: '300',
      },
      title: {
        type: String,
      }
    },
    data() {
      return {
        maxPageWidth: 10,
        pages: 0,
        rows: [],
        fetching: false,
        orderBy: null,
        sortedBy: null,
        page: 1,
        query: {},
        selectedIds: [],
      };
    },
    components: { OnePartPaginator, MultiPartPaginator },
    computed: {
      selectedItems () {
        this.$nextTick(() => this.$emit('DataTable:selectedItemChange', this.selectedIds, this.rows.length));
        return this.rows.filter(item => ~this.selectedIds.indexOf(item.id));
      },
      actionsEnablity () {
        return this.selectedItems.length ? '' : 'disabled';
      }
    },
    methods: {
      onPageChange (page) {
        this.page = page;
        this.fetch();
      },
      getTarget(target) {
        let node = target;
        while (node.parentNode.nodeName !== 'TR') {
          node = node.parentNode;
        }
        return node;
      },
      getSortOrder(target) {
        let sortOrder = target.dataset.sortOrder
        switch (sortOrder) {
          case 'asc':
            sortOrder = '';
            break;
          case 'desc':
            sortOrder = 'asc'
            break;
          default:
            sortOrder = 'desc'
        }
        return sortOrder;
      },
      setSortOrders(target, sortOrder) {
        let iterator = target.parentNode.firstChild;

        while(iterator) {
          iterator.dataset.sortOrder = '';
          iterator = iterator.nextElementSibling;
        }

        target.dataset.sortOrder = sortOrder;
      },
      onSort(event) {
        const target = this.getTarget(event.target);
        const sortedBy = this.getSortOrder(target);
        const orderBy = target.dataset.sortField;

        if (!orderBy) return;

        this.sortedBy = sortedBy;
        this.orderBy = this.sortedBy ? orderBy : '';

        this.setSortOrders(target, this.sortedBy);

        this.fetch();
      },
      fetch() {
        const meta = {
          orderBy: this.orderBy,
          sortedBy: this.sortedBy,
          page: this.page,
        };

        this.fetching = true;
        this.getData(Object.assign(meta, this.query)).then((res) => {
          this.$emit('DataTable:finish');
          if (!res.data) {
            return this.rows = res;
          }
          this.page = res.current_page;
          this.pages = res.last_page;
          this.rows = res.data;
        }).then((res) => {
          this.fetching = false;
        });
      },
    },
    created () {
      this.fetch();
      this.$on('DataTable:refresh', query => {
        this.fetch();
      });
      this.$on('DataTable:filter', query => {
        this.page = 1;
        this.query = query;
        this.fetch();
      });
      this.$on('DataTable:toggleItem', item => {
        const index = this.selectedIds.indexOf(item);
        ~index ? this.selectedIds.splice(index, 1) : this.selectedIds.push(item);
      });
      this.$on('DataTable:toggleListItems', () => {
        this.selectedIds = this.selectedIds.length > 0 ? [] : [...this.rows.map(row => row.id)];
      });
    },
    destroyed () {
      this.$off('DataTable:filter');
      this.$off('DataTable:refresh');
    }
  };
</script>

<style>
  .__checkbox {
    cursor: pointer;
  }
  .__checkbox input {
    opacity: 0;
    position: absolute;
    margin-left: 0 !important;
  }
  .__checkbox span {
    position: relative;
    display: inline-block;
    vertical-align: top;
    width: 14px;
    height: 14px;
    border-radius: 2px;
    border: 1px solid #ccc;
    text-align: center;
  }
  .__checkbox:hover span {
    border-color: #5d9cec;
  }
  .__checkbox span:before {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0;
    text-align: center !important;
    font-size: 11px;
    line-height: 12px;
    vertical-align: middle;
  }
  .__checkbox input[type=checkbox]:checked + span:before {
    color: #fff;
    opacity: 1;
    transition: color 0.3s ease-out;
  }
  .__checkbox input[type=checkbox]:checked + span {
    border-color: #5d9cec;
    background-color: #5d9cec;
  }
  .__checkbox input[type=checkbox]:disabled + span {
    border-color: #dddddd !important;
    background-color: #dddddd !important;
  }
</style>

<style scoped lang="css">
  .container {
    margin-top: 2em;
  }
  .panel {
    background: none !important;
  }
  .panel-heading {
    text-align: right !important;
    background-color: #f5f5f5 !important;
  }
  .action-block {
    display: inline-block;
  }
  th[data-sort-field]::after {
    content: "";
    font-family: 'Glyphicons Halflings';
    margin-left: 1.5em;
    vertical-align: middle;
  }
  th[data-sort-order='desc']::after {
    content: "\e252";
    margin-left: 0.5em;
  }
  th[data-sort-order='asc']::after {
    content: "\e253";
    margin-left: 0.5em;
  }
</style>
