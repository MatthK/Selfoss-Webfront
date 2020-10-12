       function getNews(tag, mlen, nrec, cat, page, cnt) {
           rNews('api/getNews.php?' + cat + 't='+tag+'&r='+nrec, cat, tag, mlen, page, cnt);
       }

       function hideArticle(itemid, star) {
          if (star == 1) {
             var str = '&s=1';
             var rmcls = 'btn-secondary';
             var adcls = 'btn-success';
             var msg = 'The article has been starred';
             jstar = 0;
          } else if (star == 0) {
             var str = '&s=0';
             var rmcls = 'btn-success';
             var adcls = 'btn-secondary';
             var msg = 'The article has been unmarked';
             jstar = 1;
          } else {
             var str = '';
          }
          $.ajax({
              url: 'api/markRead.php?i=' + itemid + str,
              type: 'GET',
              dataType: 'json',
              success: function ( data ) {
                if (str == '') {
                   $('#art'+itemid).removeClass('d-flex');
                   $('#art'+itemid).addClass('d-none');
                } else {
                   $('#infobox').html(msg);
                   $('#infobox').addClass('d-flex');
                   $('#infobox').removeClass('invisible');
                   $('#artstar').removeClass(rmcls);
                   $('#artstar').addClass(adcls);
                   setTimeout(function() { hideMsg('info'); }, imto * 1000);
                }
              },
              error: function(jqXHR, textStatus) {
                showToast('alert-danger','Request failed: ' + textStatus,imto)
              }
          });
       }

       function getInfTag(cNo, tag, vcnt) {
          if (tag.substr(0,3) == 'srx') {
             vUrl = 'api/getNews.php?c=x&' + 't='+encodeURI(tag.substr(3))+'&r='+cNo;
          } else {
             vUrl = 'api/getNews.php?c=t&' + 't='+tag+'&r='+cNo;
          }
          $.ajax({
              url: vUrl,
              type: 'GET',
              dataType: 'text',
              success: function ( data ) {
                oReply = JSON.parse( data );
                tPage(oReply, tag, vcnt);
              },
              error: function(jqXHR, textStatus) {
                showToast('alert-danger','Request failed: ' + textStatus,imto)
              }
          });
       }
 
       function rNews(rURL, cat, tag, mlen, page, cnt) {
          $.ajax({
              url: rURL,
              type: 'GET',
              dataType: 'text',
              success: function ( data ) {
                oReply = JSON.parse( data );
                if (page == 'news') {
                   uNews(oReply, tag, mlen);
                }
                uPage(oReply, cat, tag, cnt, page);
              },
              error: function(jqXHR, textStatus) {
                showToast('alert-danger','Request failed: ' + textStatus,imto)
              }
          });
       }
 
       function uNews(oReply, tag, mlen) {
          $('#' + tag + 'title').html(oReply[0].Title);
          $('#' + tag + 'updatetime').html(oReply[0].UpdateTime);
          $('#' + tag + 'source').html(oReply[0].Source);
          if (oReply[0].Content.length > mlen) {
             vcr = '...';
          } else {
             vcr = '';
          }
          $('#' + tag + 'content').html(oReply[0].Content.substring(0, mlen) + vcr);
          $('#' + tag + 'link').attr('href', oReply[0].link);
          $('#' + tag + 'title').attr('href', 'article.php?i='+oReply[0].id);
          $('#' + tag + 'id').attr('href', 'article.php?i='+oReply[0].id);
          $('#lastrf').html(getDateTime());  // update the top left last refreshed date/time
          $('#lastrfm').html(getDateTime());  // update the top left last refreshed date/time for mobiles
       }
 
       // Infinite scroll on tag + search page to add more content
       function tPage(oReply, tag, vcnt) {
          var vgC = oReply.length;
          var vHtml = '';
          for (g = 1; g < vgC; g++) {
              vHtml += '<div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative"><div class="row no-gutters overflow-hidden flex-md-row mb-4 h-md-250 position-relative"><div class="col p-2 d-flex flex-column position-static">';
              vHtml += '<div><small><a href="' + oReply[g].link + '" target="_blank"><span>' + oReply[g].Source + '</span></a> - <span class="mb-1 text-muted">' + oReply[g].updatetime + ' - ' + oReply[g].author + '</span></small></div>';
              vHtml += '<h2 class="mb-0"><a href="article.php?i=' + oReply[g].id + '" class="text-dark">' + oReply[g].title + '</a></h2><p>&nbsp;</p>';
              vHtml += '<p class="card-text mb-auto">' + oReply[g].content + '</p></div></div></div>';
          }
          let xcnt = +vcnt + 1;
          vHtml += '</div><div id="tcontent' + xcnt + '">';
          $('#tcontent'+vcnt).html(vHtml);
          $('#lastrf').html(getDateTime());  // update the top left last refreshed date/time
          $('#lastrfm').html(getDateTime());  // update the top left last refreshed date/time for mobiles
          mar = 1;
       }

       function uPage(oReply, cat, tag, cnt, page) {
          var vgC = oReply.length;
          var vHtml = '';
          if (page == 'news') {
             var gStart = 1;
          } else {
             var gStart = 0;
          }
          for (g = gStart; g < vgC; g++) {
             vHtml += '<div class="d-flex mb-3" id="art' + oReply[g].id + '"><div class="w-100"><p>';
             if (tag.substring(0, 5) == 'other') {
                vHtml += '<span><a href="tag.php?t=' + oReply[g].Tags.toLowerCase() + '" class="text-dark">' + jTags[jTags.findIndex(x => x.tag === oReply[g].Tags.toLowerCase())].name + '</a></span> - ';
             }
             vHtml += '<small><a href="' + oReply[g].link + '" class="text-black-50" target="_blank">' + oReply[g].Source + '</a>&nbsp;-&nbsp;' + oReply[g].UpdateTime + '</small><br/><a href="article.php?i=' + oReply[g].id + '" class="text-dark">' + oReply[g].Title + '</a></p></div><div class="flex-shrink-1"><button type="button" class="justify-content-end btn btn-light btn-sm" id="hide' + oReply[g].id + '">x</button></div></div>';
          }
          if (cat == 'c='+cnt+'&') {
              vHtmlm = vHtml + '</div><div id="' + tag + 'newsm' + (+cnt+1) +'">';
              vHtml += '</div><div id="' + tag + 'news' + (+cnt+1) +'">';
              $('#' + tag + 'news' + cnt).html(vHtml); 
              $('#' + tag + 'newsm' + cnt).html(vHtmlm); 
          } else {
              vHtml += '</div><div id="newssrc' + (+cnt+1) +'">';
              $('#newssrc' + cnt).html(vHtml); 
          }
          $('#lastrf').html(getDateTime());  // update the top left last refreshed date/time
          $('#lastrfm').html(getDateTime());  // update the top left last refreshed date/time for mobiles
       }

       function showToast(type,msg,timeout) {
          $('#toast-wrapper').attr('data-delay',timeout * 1000);
          $('#toast-wrapper').addClass(type);
          $('#toast-body').addClass(type);
          $('#toast-body').html(msg);
          $('.toast').toast('show');
       }       

       function setMenu(tag) {
          $('#menu'+tag).removeClass('text-muted');
          $('#menu'+tag).addClass('btn btn-secondary');
       }
       
       function checkDBot(id) {
         if (($(window).height() + $(window).scrollTop()) >= (document.getElementById(id).offsetHeight + document.getElementById(id).offsetTop)) {
            return true;
         } else {
            return false;
         }       
       }

       function getDateTime() {
               var now     = new Date(); 
               var year    = now.getFullYear();
               var month   = now.getMonth()+1; 
               var day     = now.getDate();
               var hour    = now.getHours();
               var minute  = now.getMinutes();
               var second  = now.getSeconds(); 
               if(month.toString().length == 1) {
                    month = '0'+month;
               }
               if(day.toString().length == 1) {
                    day = '0'+day;
               }   
               if(hour.toString().length == 1) {
                    hour = '0'+hour;
               }
               if(minute.toString().length == 1) {
                    minute = '0'+minute;
               }
               if(second.toString().length == 1) {
                    second = '0'+second;
               }   
               var dateTime = day+'.'+month+'.'+year+' '+hour+':'+minute+':'+second;   
               return dateTime;
           }