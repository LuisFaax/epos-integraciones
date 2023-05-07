(function($) {
    /* "use strict" */
	
	var customerMap = function(){
         var options = {
          series: [{
          name: 'Sales',
          data: [80, 24, 80, 90, 80, 70, 20, 85, 80, 45, 25, 65]
        }, {
          name: 'Orders',
          data: [40, 60, 20, 60, 60, 20, 60, 25, 40, 65, 15, 40]
        }, {
          name: 'Others',
          data: [20, 17, 5, 20, 20, 10, 15, 10, 15, 20, 60, 15]
        }],
          chart: {
          type: 'bar',
          height: 400,
		  toolbar:{
			show:false
		  },
		  zoom: {
				enabled: false
			}
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '47%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
			show: true,
          width: 3,
          colors: ['transparent']
        },
		legend: {
			fontSize: '12px',
			 markers: {
			  width: 20,
			  height: 20
			},
			itemMargin: {
				  horizontal: 10,
				  vertical: 10
			  },
		},
        xaxis: {
          categories: [ 'jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','nov','dec'],
		  labels: {
				style: {
					colors: '#787878',
					fontSize: '13px',
					fontFamily: 'Poppins',
					fontWeight: 400
					
				},
			}
        },
        yaxis: {
			labels: {
				offsetX: -15,
					style: {
						colors: '#787878',
						fontSize: '13px',
						fontFamily: 'Poppins',
						fontWeight: 400
						
					},
				}
        },
		colors:['#ff720d','#787878','#C4C4C4'],
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        },
		responsive: [{
			breakpoint: 575,
			options: {
				series: [{
				  name: 'Income',
				  data: [80, 24, 80, 90, 80, 70]
				}, {
				  name: 'Expense',
				  data: [40, 60, 20, 60, 60, 20]
				}, {
				  name: 'Others',
				  data: [20, 17, 5, 20, 20, 10]
				}],
				chart: {
				  height: 250,
				},
				 plotOptions: {
				  bar: {
					columnWidth: '65%'
				  },
				},
				xaxis: {
				  categories: [ 'jan','Feb', 'Mar', 'Apr', 'May', 'Jun'],
				},
			},
		}]

        };

        var chart = new ApexCharts(document.querySelector("#customerMap"), options);
        chart.render();
		
	}
	
	var customerMap2 = function(){
         var options = {
          series: [{
          name: 'Income',
          data: [80, 24, 80, 90, 80, 70, 20, 85, 80, 45, 25, 65]
        }, {
          name: 'Expense',
          data: [40, 60, 20, 60, 60, 20, 60, 25, 40, 65, 15, 40]
        }, {
          name: 'Others',
          data: [20, 17, 5, 20, 20, 10, 15, 10, 15, 20, 60, 15]
        }],
          chart: {
          type: 'bar',
          height: 400,
		  toolbar:{
			show:false
		  }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '47%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
			show: true,
          width: 3,
          colors: ['transparent']
        },
		legend: {
			fontSize: '12px',
			 markers: {
			  width: 20,
			  height: 20
			},
			itemMargin: {
				  horizontal: 10,
				  vertical: 10
			  },
		},
        xaxis: {
          categories: [ 'jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','nov','dec'],
		  labels: {
				style: {
					colors: '#787878',
					fontSize: '13px',
					fontFamily: 'Poppins',
					fontWeight: 400
					
				},
			}
        },
        yaxis: {
			labels: {
					style: {
						colors: '#787878',
						fontSize: '13px',
						fontFamily: 'Poppins',
						fontWeight: 400
						
					},
				}
        },
		colors:['#ff720d','#787878','#C4C4C4'],
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        },
		responsive: [{
			breakpoint: 575,
			options: {
				series: [{
				  name: 'Income',
				  data: [80, 24, 80, 90, 80, 70]
				}, {
				  name: 'Expense',
				  data: [40, 60, 20, 60, 60, 20]
				}, {
				  name: 'Others',
				  data: [20, 17, 5, 20, 20, 10]
				}],
				chart: {
				  height: 250,
				},
				 plotOptions: {
				  bar: {
					columnWidth: '65%'
				  },
				},
				xaxis: {
				  categories: [ 'jan','Feb', 'Mar', 'Apr', 'May', 'Jun'],
				},
			},
		}]
		
        };

        var chart = new ApexCharts(document.querySelector("#customerMap2"), options);
        chart.render();
		
	}
	
	var customerMap3 = function(){
         var options = {
          series: [{
          name: 'Income',
          data: [80, 24, 80, 90, 80, 70, 20, 85, 80, 45, 25, 65]
        }, {
          name: 'Expense',
          data: [40, 60, 20, 60, 60, 20, 60, 25, 40, 65, 15, 40]
        }, {
          name: 'Others',
          data: [20, 17, 5, 20, 20, 10, 15, 10, 15, 20, 60, 15]
        }],
          chart: {
          type: 'bar',
          height: 400,
		  toolbar:{
			show:false
		  }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '47%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
			show: true,
          width: 3,
          colors: ['transparent']
        },
		legend: {
			fontSize: '12px',
			 markers: {
			  width: 20,
			  height: 20
			},
			itemMargin: {
				  horizontal: 10,
				  vertical: 10
			  },
		},
        xaxis: {
          categories: [ 'jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','nov','dec'],
		  labels: {
				style: {
					colors: '#787878',
					fontSize: '13px',
					fontFamily: 'Poppins',
					fontWeight: 400
					
				},
			}
        },
        yaxis: {
			labels: {
					style: {
						colors: '#787878',
						fontSize: '13px',
						fontFamily: 'Poppins',
						fontWeight: 400
						
					},
				}
        },
		colors:['#ff720d','#787878','#C4C4C4'],
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        },
		
		responsive: [{
			breakpoint: 575,
			options: {
				series: [{
				  name: 'Income',
				  data: [80, 24, 80, 90, 80, 70]
				}, {
				  name: 'Expense',
				  data: [40, 60, 20, 60, 60, 20]
				}, {
				  name: 'Others',
				  data: [20, 17, 5, 20, 20, 10]
				}],
				chart: {
				  height: 250,
				},
				 plotOptions: {
				  bar: {
					columnWidth: '65%'
				  },
				},
				xaxis: {
				  categories: [ 'jan','Feb', 'Mar', 'Apr', 'May', 'Jun'],
				},
			},
		}]
		
        };

        var chart = new ApexCharts(document.querySelector("#customerMap3"), options);
        chart.render();
		
	}
	
	// 
	
 
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){					
					customerMap();
					customerMap2();
					customerMap3();
			},
			
			resize:function(){
			}
		}
	
	}();

	jQuery(document).ready(function(){
	});
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

	jQuery(window).on('resize',function(){
		
		
	});     

})(jQuery);