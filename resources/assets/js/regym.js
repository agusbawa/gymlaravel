 	$(document).ready(function(){
    reGym.init();
});

var reGym = {
    init : function(){
        // Init Material scripts for buttons ripples, inputs animations etc, more info on the next link https://github.com/FezVrasta/bootstrap-material-design#materialjs
        this.pageScriptInit();
        this.formConfirm();

        //  Activate the Tooltips
        $('[data-toggle="tooltip"], [rel="tooltip"]').tooltip();

        // Activate Popovers
        $('[data-toggle="popover"]').popover();

        // Active Carousel
	    $('.carousel').carousel({
            interval: 400000	 	
        });

        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });

        $(".knob").knob();

		$(".select2").select2();

		jQuery('.datepicker').datepicker({
			format: "dd-mm-yyyy",
			todayHighlight: true,
			
		});

		$('.input-daterange-datepicker').daterangepicker({
                    autoUpdateInput: false,
			locale: {
				format: "DD-MM-YYYY",
                                cancelLabel: 'Clear',
			},
			buttonClasses: ['btn', 'btn-sm'],
			applyClass: 'btn-default',
			cancelClass: 'btn-white'
		});
                $('.input-daterange-datepicker').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                });

                $('.input-daterange-datepicker').on('cancel.daterangepicker', function(ev, picker) {
                      $(this).val('');
                  });

		$('.summernote').summernote({
			height: 350,                 // set editor height
			minHeight: null,             // set minimum height of editor
			maxHeight: null,             // set maximum height of editor
			focus: false                 // set focus to editable area after initializing summernote
		});

        remagineGMap.init();

        // Select2 to SelectAll
        $('.select2-bulkaction').click(function(){
        	if ($(this).data('type')=="deselect") {
        		var target 			=	$(this).data('target');
        		var selectedItems 	=	[];
        		$(target).select2("val", selectedItems);
        	}
        	else
        	{
				var target 			=	$(this).data('target');
	        	var selectedItems 	= $(target).select2('val');
	        	var allOptions = $(target + " option");
	    	    for (var i = 0; i < allOptions.length; i++) {
	    	        selectedItems.push($(allOptions[i]).val());
	    	    }
	        	$(target).select2("val", selectedItems);
        	}
        });
        
        $('.showdata-listGym').click(function(){
            var th = $(this).attr('data-id');
          $.get('/u/zonas/list/'+th,function(data){
             
            		data 	=	JSON.parse(data);
                        var dt = '';
            		data.forEach(function(value, index, ar){
                            dt += "<li>"+value.title+"</li>";
            			
            		});
                        $("#dataListgym-place").html(dt);
                        $("#modallistgym").modal('show')
            	});
        });
        // $('.select2-bulkaction').click(function(){
        	
        // });
    },
    pageScriptInit : function(page){
        self = this;

        // Global Script
        this.addPageScript('*', function(){
            
        });

        this.addPageScript('/u/gyms/*', function(){
            if($('.member-growth').length > 0)
            {
                var colors = ['#5fbeaa', '#34d3eb'];
                var borderColor = '#f5f5f5';
                var bgColor = '#fff';
				var data = [{
					data : window.memberGrowth,
					label : 'Member',
					color : colors[1]
				}];
                self.createPlotGraph('.member-growth', data, borderColor, bgColor);
            }
        });

        this.addPageScript('/u/members/extend/*', function(){
            $("select[name='packages']").change(function() {
            	var me = $(this);
            	var target 	=	$("select[name='package_price']");
            	target.prop('disabled',true);
            	target.html('');

            	$.get('/u/packages/'+me.val()+'/prices',function(data){
            		data 	=	JSON.parse(data);
            		data.forEach(function(value, index, ar){
            			target.append('<option value="'+ value.id +'">'+ value.title +' - Rp.'+ value.price.formatMoney(0) +'</option>');
            		});
            	});

            	target.prop('disabled',false);
            });
        });
        
        this.addPageScript('/u/poolings/create', function(){
            $("button#addVoteItem").click(function(){
               var add = '<div class="form-group label-floating"><input type="text" class="form-control" name="item[]" value=""> <button type="button" class="btn btn-danger remove-item">X</button></div>';
               $("#addItemdata").append(add).ready(function(){
                   $(".remove-item").click(function(){
                       $(this).parent('div').remove();
                   });
               });
            });
        });
        
        this.addPageScript('/u/poolings/*/edit', function(){
            $(".remove-item").click(function(){
                       $(this).parent('div').remove();
                   });
            $("button#addVoteItem").click(function(){
               var add = '<div class="form-group label-floating"><input type="text" class="form-control" name="item[]" value=""> <button type="button" class="btn btn-danger remove-item">X</button></div>';
               $("#addItemdata").append(add).ready(function(){
                   $(".remove-item").click(function(){
                       $(this).parent('div').remove();
                   });
               });
            });
        });
        
        this.addPageScript('/u/packages', function(){
            $('.showdata-listHarga').click(function(){
                var th = $(this).attr('data-id');
                $.get('/u/packages/list/'+th,function(data){
             
            		data 	=	JSON.parse(data);
                        var dt = '';
            		data.forEach(function(value, index, ar){
                            dt+='<tr>';
                            dt+='<td>'+value.title+'</td>';
                            dt+='<td>'+value.day+'</td>';
                            dt+='<td>'+value.price+'</td>';
                            dt+='</tr>';
            			
            		});
                        $(".placelistharga").children('tbody').html(dt);
                        $("#modalLIstHarga").modal('show')
            	});
                
            });
        });
        
        this.addPageScript('/u/gymsharian/*', function(){
            $("#gym_id").change(function(){
                var id = $('option:selected', this).attr('data-package');
                $("option.default-package").hide();
                $("option.pck_"+id).show();
            });
        });

		this.addPageScript('/u/packages/*/prices', function(){
			// var d1 = [];
			// for (var i = 0; i <= 10; i += 1)
			// 	d1.push([i, parseInt(Math.random() * 30)]);

			// var d2 = [];
			// for (var i = 0; i <= 10; i += 1)
			// 	d2.push([i, parseInt(Math.random() * 30)]);

			// var d3 = [];
			// for (var i = 0; i <= 10; i += 1)
			// 	d3.push([i, parseInt(Math.random() * 30)]);

			// var ds = new Array();

			// ds.push({
			// 	label : "Data One",
			// 	data : d1,
			// 	bars : {
			// 		order : 1
			// 	}
			// });
			// ds.push({
			// 	label : "Data Two",
			// 	data : d2,
			// 	bars : {
			// 		order : 2
			// 	}
			// });
			// ds.push({
			// 	label : "Data Three",
			// 	data : d3,
			// 	bars : {
			// 		order : 3
			// 	}
			// });

			// var stack = 0,
			// 	bars = false,
			// 	lines = false,
			// 	steps = false;

			// var options = {
			// 	bars : {
			// 		show : true,
			// 		barWidth : 0.2,
			// 		fill : 1
			// 	},
			// 	grid : {
			// 		show : true,
			// 		aboveData : false,
			// 		labelMargin : 5,
			// 		axisMargin : 0,
			// 		borderWidth : 1,
			// 		minBorderMargin : 5,
			// 		clickable : true,
			// 		hoverable : true,
			// 		autoHighlight : false,
			// 		mouseActiveRadius : 20,
			// 		borderColor : '#f5f5f5'
			// 	},
			// 	series : {
			// 		stack : stack
			// 	},
			// 	legend : {
			// 		position : "ne",
			// 		margin : [0, -24],
			// 		noColumns : 0,
			// 		labelBoxBorderColor : null,
			// 		labelFormatter : function(label, series) {
			// 			// just add some space to labes
			// 			return '' + label + '&nbsp;&nbsp;';
			// 		},
			// 		width : 30,
			// 		height : 2
			// 	},
			// 	yaxis : {
			// 		tickColor : '#f5f5f5',
			// 		font : {
			// 			color : '#bdbdbd'
			// 		}
			// 	},
			// 	xaxis : {
			// 		tickColor : '#f5f5f5',
			// 		font : {
			// 			color : '#bdbdbd'
			// 		}
			// 	},
			// 	colors : ["#6e8cd7", "#34d3eb", "#5fbeaa"],
			// 	tooltip : true, //activate tooltip
			// 	tooltipOpts : {
			// 		content : "%s : %y.0",
			// 		shifts : {
			// 			x : -30,
			// 			y : -50
			// 		}
			// 	}
			// };


            // $.plot($("#package-buy"), ds, options);
        });
    },
    addPageScript:function(str, script){
        if(this.matchRuleShort(window.location.pathname, str)){
            if(script instanceof Function) {
                script();
            } else {
                throw "Aturan '" + str + "' Tidak memiliki function";
            }
        }
    },
    matchRuleShort: function(str, rule)
    {
        return new RegExp("^" + rule.split("*").join(".*") + "$").test(str);
    },
    formConfirm : function()
    {
        
		$('form.confirm').submit(function(e){
			var self = $(this);
			e.preventDefault();

			swal({   title: "Apakah Anda yakin?",   text: $(this).data('message') || "Setelah dihapus data ini tidak akan dapat direcovery!",   type: "warning",   showCancelButton: true, confirmButtonText: "Ya!", cancelButtonText: "Batal",   closeOnConfirm: false }, function(){   
				self.unbind('submit').submit();
			});

			return false;
		});

        // $('.btn-confirm').each(function(){
        //     self = $(this);
            
        // });
    },
    createPlotGraph : function(selector, data, borderColor, bgColor) {
		//shows tooltip
		function showTooltip(x, y, contents) {
			$('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css({
				position : 'absolute',
				top : y + 5,
				left : x + 5
			}).appendTo("body").fadeIn(200);
		}


		$.plot($(selector), data, {
			series : {
				lines : {
					show : true,
					fill : true,
					lineWidth : 1,
					fillColor : {
						colors : [{
							opacity : 0.5
						}, {
							opacity : 0.5
						}]
					}
				},
				points : {
					show : true
				},
				shadowSize : 0
			},

			grid : {
				hoverable : true,
				clickable : true,
				borderColor : borderColor,
				tickColor : "#f9f9f9",
				borderWidth : 1,
				labelMargin : 10,
				backgroundColor : bgColor
			},
			legend : {
				position : "ne",
				margin : [0, -24],
				noColumns : 0,
				labelBoxBorderColor : null,
				labelFormatter : function(label, series) {
					// just add some space to labes
					return '' + label + '&nbsp;&nbsp;';
				},
				width : 30,
				height : 2
			},
			yaxis : {
				tickColor : '#f5f5f5',
				font : {
					color : '#bdbdbd'
				}
			},
			xaxis : {
				tickColor : '#f5f5f5',
				font : {
					color : '#bdbdbd'
				},
				mode: "time",
				minTickSize: [1, "month"],
				timeformat: "%b %Y"
			},
			tooltip : true,
			tooltipOpts : {
				content : '%s: Value of %x is %y',
				shifts : {
					x : -60,
					y : 25
				},
				defaultTheme : false
			}
		});
	}
}

var remagineGMap = {
	map:null,
	marker:false,
	location:null,
	autocomplete:null,
	locationAddress:null,
	autocompleteBox:null,
    latbox:null,
    longbox:null,

	init:function()
	{
        var self = this;

        var map     =   $("[data-type='map']");
        if(map.length < 1)
        {
            return;
        }
        
        map.height(map.data('height') || 300);
        var latitude        = map.data('latitude') || -8.65;
        var longitude       = map.data('longitude') || 115.21667;

        this.map 	            =   map;
        this.autocompleteBox    =   $(map.data('search-input'));
        this.latbox             =   $(map.data('latbox'));
        this.longbox            =   $(map.data('longbox'));

        this.latitude           =   this.latbox.val() || -8.65;
        this.longitude          =   this.longbox.val() || 115.21667;
        this.location           =   {lat: parseFloat(this.latitude), lng: parseFloat(this.longitude)};

        this.map = new google.maps.Map(map[0], {
                center: this.location,
                scrollwheel: false,
                zoom: 15
            });

        this.setMarker(this.location);

        var options = {
            types: ['geocode'],
            componentRestrictions: {country: 'id'}
        };

        this.autocomplete = new google.maps.places.Autocomplete(this.autocompleteBox[0], options);
        google.maps.event.addListener(self.autocomplete, 'place_changed', function () {
            var place = self.autocomplete.getPlace();
            self.setMarker(place.geometry.location);
            self.setMapCenter(place.geometry.location);
            self.setToTextbox({
                    lat: place.geometry.location.lat(),
                    lng: place.geometry.location.lng()
                });
        });

        this.setToTextbox(this.location);
	},
	setMarker:function(location){
		var self = this;
		if (this.marker) {
		    this.marker.setPosition(location);
		    self.location = location;
		} else {
		    this.marker = new google.maps.Marker({
		    	position: location,
		      	map: this.map,
		      	draggable:true
		    });

		    google.maps.event.addListener(
		        this.marker,
		        'dragend',
		        function(event) {
		        	location = {
		        		lat: event.latLng.lat(),
		        		lng: event.latLng.lng()
		        	}

		        	self.location = location;
					self.setMapCenter(location);
					self.setLocationAddress(location);
					self.setToTextbox(location);
		        }
		    );
		}
	},
	setMapCenter:function(location){
		this.map.setOptions({
	        center: location,
	        zoom: 15
	    });
	},
	setLocationAddress:function(location){
		// formatted_address
		var self = this;
		$.get("https://maps.googleapis.com/maps/api/geocode/json", { 
			latlng: location.lat+","+location.lng,
			location_type:"ROOFTOP",
			result_type:"street_address",
			key:"AIzaSyCxtzVR8BAw-AW0GsI8-hPiONtcPYyt23Q"
		 } );
	},
	setToTextbox:function(location){
		this.latbox.val(location.lat);
		this.longbox.val(location.lng);
	}
}

Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };