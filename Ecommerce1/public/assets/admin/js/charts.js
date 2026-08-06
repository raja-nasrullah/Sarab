// resources/js/charts.js
import * as echarts from 'echarts';

// Chart configurations
const chartConfigs = {
    'dashboard-network': {
        tooltip: {
            trigger: 'axis',
            axisPointer: { type: 'shadow' }
        },
        legend: {
            data: ['Sessions', 'Page Views'],
            bottom: 0,
            icon: 'circle',
            itemWidth: 8,
            itemHeight: 8,
            textStyle: { fontSize: 11, color: '#6b7280' }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '15%',
            top: '8%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            axisLine: { lineStyle: { color: '#e5e7eb' } },
            axisLabel: { color: '#6b7280', fontSize: 11 }
        },
        yAxis: {
            type: 'value',
            splitLine: { lineStyle: { color: '#f3f4f6', type: 'dashed' } },
            axisLabel: { color: '#6b7280', fontSize: 11 }
        },
        series: [
            {
                name: 'Sessions',
                type: 'bar',
                barWidth: '35%',
                itemStyle: {
                    color: '#1ABB9C',
                    borderRadius: [4, 4, 0, 0]
                },
                data: [320, 450, 380, 520, 490, 680, 750]
            },
            {
                name: 'Page Views',
                type: 'line',
                smooth: true,
                symbol: 'circle',
                symbolSize: 6,
                lineStyle: {
                    color: '#066fd1',
                    width: 2
                },
                itemStyle: {
                    color: '#066fd1'
                },
                areaStyle: {
                    color: 'rgba(6, 111, 209, 0.1)'
                },
                data: [480, 620, 550, 700, 680, 850, 920]
            }
        ]
    },
    'device-usage': {
        tooltip: {
            trigger: 'item',
            formatter: '{b}: {c}%'
        },
        series: [
            {
                type: 'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                itemStyle: {
                    borderRadius: 4,
                    borderColor: '#fff',
                    borderWidth: 2
                },
                label: { show: false },
                emphasis: {
                    label: { show: true, fontSize: 12, fontWeight: 'bold' }
                },
                data: [
                    { value: 30, name: 'iOS', itemStyle: { color: '#1ABB9C' } },
                    { value: 25, name: 'Android', itemStyle: { color: '#066fd1' } },
                    { value: 20, name: 'Desktop', itemStyle: { color: '#f59f00' } },
                    { value: 15, name: 'Tablet', itemStyle: { color: '#ae3ec9' } },
                    { value: 10, name: 'Other', itemStyle: { color: '#d1d5db' } }
                ]
            }
        ]
    },
    'revenue-line': {
        tooltip: {
            trigger: 'axis'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '10%',
            top: '8%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisLine: { lineStyle: { color: '#e5e7eb' } },
            axisLabel: { color: '#6b7280', fontSize: 11 }
        },
        yAxis: {
            type: 'value',
            splitLine: { lineStyle: { color: '#f3f4f6', type: 'dashed' } },
            axisLabel: { color: '#6b7280', fontSize: 11 }
        },
        series: [
            {
                type: 'line',
                smooth: true,
                symbol: 'circle',
                symbolSize: 6,
                lineStyle: {
                    color: '#1ABB9C',
                    width: 2
                },
                itemStyle: {
                    color: '#1ABB9C'
                },
                areaStyle: {
                    color: 'rgba(26, 187, 156, 0.15)'
                },
                data: [12000, 14500, 13800, 16200, 15800, 18200, 19500, 21000, 22800, 24500, 23800, 25600]
            }
        ]
    }
};

// Initialize charts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initCharts();
});

// Also initialize on theme change
document.documentElement.addEventListener('themechange', function() {
    // Re-initialize charts with new theme
    setTimeout(initCharts, 100);
});

function initCharts() {
    const chartElements = document.querySelectorAll('[data-chart]');
    
    chartElements.forEach(function(element) {
        const chartType = element.dataset.chart;
        const config = chartConfigs[chartType];
        
        if (!config) {
            console.warn('Chart config not found for:', chartType);
            return;
        }
        
        // Dispose existing chart if any
        let chart = echarts.getInstanceByDom(element);
        if (chart) {
            chart.dispose();
        }
        
        // Create new chart
        chart = echarts.init(element);
        
        // Set options
        chart.setOption(config);
        
        // Handle resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                chart.resize();
            }, 100);
        });
    });

}

export { initCharts };