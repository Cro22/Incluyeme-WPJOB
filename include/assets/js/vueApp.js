let filterApplicants = new Vue({
    el: '#filterApplicants',
    data: {
        message: 'We are working on this section, we are sorry for the inconvenience. Date:' + new Date().toLocaleString(),
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
            this.message = 'We are working on this section, we are sorry for the inconvenience. Date:' + new Date().toLocaleString() + ' You Search For: ' + JSON.stringify({
                jobs: this.jobs,
                city: this.city,
                keyPhrase: this.keyPhrase,
                course: this.course,
                name: this.name,
                lastName: this.lastName,
                oral: this.oral,
                idioms: this.idioms,
                education: this.education,
                description: this.description,
                residence: this.residence,
                letter: this.letter,
                email: this.email,
                leido: this.leido,
                desestimado: this.desestimado,
                preseleccionado: this.preseleccionado,
                seleccionado: this.seleccionado,
                motriz: this.motriz,
                auditive: this.auditive,
                visual: this.visual,
                visceral: this.visceral,
                intelectual: this.intelectual,
                psiquica: this.psiquica,
                habla: this.habla,
                ninguna: this.ninguna,
            })
            this.message = jQuery.ajax({
                url: url,
                data: {id: userId},
                type: 'POST',
                dataType: 'json',
                success: function (json) {
                   return  json
                },
                error: function (xhr, status) {
                    alert('Disculpe, hay un problema');
                },
            });
        },
        onClassChange(classAttrValue) {
            const classList = classAttrValue.split(' ');
            if (classList.includes('show')) {
                this.searchEnable = false
            }
        }
    }
});