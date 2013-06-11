Crowd Computer JS libraries  
=====
This is the repository of all the library (JS) that are wrote to be used for the comunication between requester's pages and CrowdComputer

##Content
###croco.js 
This js is an hub that decide what library has to be load (among croco4CC and croco4TurkAndCC). Ideally a user should just include this library (and have the others in the same folder).
               
###croco4CC.js 
This library does a two calls, first sends the form data to the requester page.
If the requester's page returns data, those data are added to the forma nd sent to the crowdcomputer in the second call.
The second call, in fact, sends the form data to crowdcomputer. 
so it sends to:
- requeter's page
- crowdcomputer

NB: only fields that have `class="croco"` are sent to crowdcomputer.

###croco4TurkAndCC.js:    
This library does three calls. 
Similarly as above, it sends to:
- requester's page
- crowdcomputer
- mechanical turk. 
           
NB: only fields that have `class="croco"` are sent to crowdcomputer.   
