let filterApplicants = new Vue({
    el: '#incluyeme-wpjb',
    data: {
        message: false,
        searchEnable: false,
        jobs: null,
        city: null,
        keyPhrase: null,
        course: null,
        name: null,
        lastName: null,
        oral: null,
        idioms: null,
        education: null,
        description: null,
        residence: null,
        letter: null,
        email: null,
        leido: null,
        desestimado: null,
        preseleccionado: null,
        seleccionado: null,
        motriz: null,
        auditive: null,
        visual: null,
        visceral: null,
        intelectual: null,
        psiquica: null,
        habla: null,
        ninguna: null,
    },
    mounted() {
        this.observer = new MutationObserver(mutations => {
            for (const m of mutations) {
                const newValue = m.target.getAttribute(m.attributeName);
                this.$nextTick(() => {
                    this.onClassChange(newValue, m.oldValue);
                });
            }
        });

        this.observer.observe(this.$refs.filterApplicants, {
            attributes: true,
            attributeOldValue: true,
            attributeFilter: ['class'],
        });
    },
    beforeDestroy() {
        this.observer.disconnect();
    },
    methods: {
        filterData: async function (userId, url) {
            console.log({userId, url})
            this.searchEnable = true;
            url = url + '/incluyeme/include/verifications.php';
            jQuery("#filterApplicants").modal('hide');//ocultamos el modal
            jQuery('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
            jQuery('.modal-backdrop').remove();//eliminamos el backdrop del modal
            this.message = 'Buscando...';
            let request = await jQuery.ajax({
                url: url,
                data: {id: userId},
                type: 'POST',
                dataType: 'json'
            }).done(success => {
                return success
            }).fail((error) => {
                return 'Disculpe, hay un problema';
            });
            if (typeof request === 'string') {
                this.message = request
            } else {
                if (request.message.length) {
                    this.message = request.message;
                } else {
                    this.message = 'No hay resultados';
                }
            }
        },
        onClassChange(classAttrValue) {
            const classList = classAttrValue.split(' ');
            if (classList.includes('show')) {
                this.searchEnable = false
            }
        }
    }
});