/**
* Created with JetBrains WebStorm.
* User: Digvijay.Upadhyay
* Date: 4/9/14
* Time: 3:12 PM
* To change this template use File | Settings | File Templates.
*/
var propagandaList = [];
var uniqueTags = [];
var incidentsShortlist = [];
function clsDataProvider(pConfig) {
    var me = this;

    //me.dateParser = d3.time.format("%m/%e/%y %H:%M").parse;
    me.dateParser = d3.time.format("%Y-%m-%dT%H:%M:%S.%LZ").parse;
    me.dateParser2 = d3.time.format("%Y-%m-%dT%H:%M:%S").parse;
    me.dateParser1 = d3.time.format("%m/%e/%Y").parse;
    me.dateParser3 = d3.time.format("%d-%b-%Y %H:%M:%S").parse;

    //-----------------------------------------------------------------------//
    me.constructor = function (pConfig) {
        for (pName in pConfig) {
            me[pName] = pConfig[pName];
        }
    };

    //-----------------------------------------------------------------------//
    me.loadData = function (pCallBack) {
                    d3.json("data/Data.json", function (incidents) {
                        debugger;
                        me.incidents = incidents;
                        console.log(propagandaList);
                        pCallBack(me);
                    });
    };


 

    //-----------------------------------------------------------------------//
    me.getIncidents = function () {

        return me.incidents;
    };

    me.constructor(pConfig);
    return me;
}