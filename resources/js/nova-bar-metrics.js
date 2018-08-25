import BarChartMetric from './components/BarChartMetric'
import BaseBarChartMetric from './components/Base/BarChartMetric'

Nova.booting((Vue, router) => {
    Vue.config.devtools = true
    Vue.component('base-bar-chart-metric', BaseBarChartMetric)
    Vue.component('bar-chart-metric', BarChartMetric)
})
