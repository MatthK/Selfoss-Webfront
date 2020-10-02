
       function getNews(tag, mlen, nrec, cat, page) {
           rNews('api/getNews.php?' + cat + 't='+tag+'&r='+nrec, cat, tag, mlen, page);
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
                showMsg('err','Request failed: ' + textStatus,imto)
              }
          });
       }

       function rNews(rURL, cat, tag, mlen, page) {
          $.ajax({
              url: rURL,
              type: 'GET',
              dataType: 'text',
              success: function ( data ) {
                oReply = JSON.parse( data );
                if (page == 'news') {
                   uNews(oReply, tag, mlen);
                }
                uPage(oReply, cat, tag);
              },
              error: function(jqXHR, textStatus) {
                showMsg('err','Request failed: ' + textStatus,imto)
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
       }
 
       function uPage(oReply, cat, tag) {
          var vgC = oReply.length;
          var vHtml = '<div>';
          for (g = 1; g < vgC; g++) {
             vHtml += '<div class="d-flex mb-3" id="art' + oReply[g].id + '"><div class="w-100"><p>';
             if (tag.substring(0, 5) == 'other') {
                vHtml += '<span><a href="tag.php?t=' + oReply[g].Tags.toLowerCase() + '" class="text-dark">' + jTags[jTags.findIndex(x => x.tag === oReply[g].Tags.toLowerCase())].name + '</a></span> - ';
             }
             vHtml += '<small><a href="' + oReply[g].link + '" class="text-black-50" target="_blank">' + oReply[g].Source + '</a>&nbsp;-&nbsp;' + oReply[g].UpdateTime + '</small><br/><a href="article.php?i=' + oReply[g].id + '" class="text-dark">' + oReply[g].Title + '</a></p></div><div class="flex-shrink-1"><button type="button" class="justify-content-end btn btn-light btn-sm" id="hide' + oReply[g].id + '">x</button></div></div>';
          }
          vHtml += '</div>';
          if (cat == '') {
              $('#' + tag + 'news').html(vHtml); 
              $('#' + tag + 'news2').html(vHtml); 
          } else {
              $('#newssrc').html(vHtml); 
          }
          $('#lastrf').html(getDateTime());  // update the top left last refreshed date/time
       }

       function showToast(msg) {
          $('#toast-body').html(msg);
          $('.toast').toast('show');
       }       

       function showMsg(box,msg,timeout) {
          $('#'+box+'box').html(msg);
          $('#'+box+'box').addClass('d-flex');
          $('#'+box+'box').removeClass('invisible');
          setTimeout(function() { hideMsg(box); }, timeout * 1000);
       }

       function hideMsg(box,) {
          $('#'+box+'box').removeClass('d-flex');
          $('#'+box+'box').addClass('invisible');
          $('#'+box+'msg').html('');
       }
       
       function setMenu(tag) {
          $('#menu'+tag).removeClass('text-muted');
          $('#menu'+tag).addClass('btn btn-secondary');
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