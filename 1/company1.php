<!DOCTYPE html>
<!-- HTML5 Hello world by kirupa - http://www.kirupa.com/html5/getting_your_feet_wet_html5_pg1.htm -->
<html>

<head>
<meta charset="utf-8">
<title>Hello</title>
<style type="text/css">
#viz {
    
}

.link {
    fill: none;
    stroke: #bbb;
    stroke-opacity: 2.6;
}
.node text {
  stroke-width: 1.5px;
  fill: #3cb371;
  pointer-events: none;
  font: 10px sans-serif;
}

</style>
</head>

<body>
<div id="viz" />
<script type="text/javascript" src="./jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="./d3.js"></script>
<script type="text/javascript">    

window.addEventListener('load', function (){
    
    
    var width = 700,
        height = 600;


    var svg = d3.select("#viz")
        .append("svg")
        .attr("width", width)
        .attr("height", height);

    renderGraph(svg, width, height, data2);

}, true);


function renderGraph(svg, width, height, graph) {
    //slice up the data:
    var nodes = graph.nodes.slice(),
        links = [],
        bilinks = [];

    var color = d3.scale.category10();

    graph.links.forEach(function (link) {
   
        var s = nodes[link.source],
            t = nodes[link.target],
            i = {}; // a single intermediate node
        

        nodes.push(i);


        links.push({
            source: s,
            target: i 
        }, {
            source: i,
            target: t
        });
        bilinks.push([s, i, t]);
    });

    var force = d3.layout.force()
        .linkDistance(70)
        .linkStrength(2)
        .size([width, height]);

    
    
        var link = svg.selectAll(".link")
        //Note ref to bilink, not links.
        .data(bilinks)
        .enter().append("path")
        .attr("class", "link")
        .style("marker-end",  "url(#suit)"); // Modified line 

    var node = svg.selectAll(".node")
        .data(graph.nodes)
        .enter()
        .append("g")
        .attr("class", "node")
        .call(force.drag);
        node.append("circle")
        .attr("r", 5)
        .style("fill", function (d) { return color(d.group);})
        .on('dblclick', connectedNodes); //Added code for highlighting


    force.nodes(nodes) 
        .links(links) 
        .start();

    
node.append("circle")
    .attr("r", 5)
    .style("fill", function (d) {
    return color(d.group);
})


    node.append("text")
      .attr("dx", 10)
      .attr("dy", ".35em")
      .text(function(d) { return d.name })
  //    .style("stroke" "gray");
    

    force.on("tick", function () {

        node.attr("transform", function (d) {
            return "translate(" + d.x + "," + d.y + ")";
        });


        link.attr("d", function (d) {
            return "M" + d[0].x + "," + d[0].y + "S" + d[1].x + "," + d[1].y + " " + d[2].x + "," + d[2].y;
        });
        
    });
    
    
    
//---Insert-------for highlighting

var toggle = 0;

var linkedByIndex = {};
for (i = 0; i < graph.nodes.length; i++) {
    linkedByIndex[i + "," + i] = 1;
};
graph.links.forEach(function (d) {
    linkedByIndex[d.source.index + "," + d.target.index] = 1;
});

 
function neighboring(a, b) {
    return linkedByIndex[a.index + "," + b.index];
}

function connectedNodes() {

    if (toggle == 0) {
     
        d = d3.select(this).node().__data__;
        node.style("opacity", function (o) {
            return neighboring(d, o) | neighboring(o, d) ? 1 : 0.1;
        });
        
        link.style("opacity", function (o) {
            return d.index==o.source.index | d.index==o.target.index ? 1 : 0.1;
        });
        
        //Reduce the op
        
        toggle = 1;
    } else {
        //Put them back to opacity=1
        node.style("opacity", 1);
        link.style("opacity", 1);
        toggle = 0;
    }

}

//---End Insert---    

    
//---Insert------- for arrows 
       
svg.append("defs").selectAll("marker")
    .data(["suit", "licensing", "resolved"])
  .enter().append("marker")
    .attr("id", function(d) { return d; })
    .attr("viewBox", "0 -5 10 10")
    .attr("refX", 19)
    .attr("refY", 0)
    .attr("markerWidth", 6)
    .attr("markerHeight", 6)
    .attr("orient", "auto")
  .append("path")
    .attr("d", "M0,-5L10,0L0,5 L10,0 L0, -5")
    .style("stroke", "#4679BD")
    .style("opacity", "0.6");
//---End Insert---
    

};

var data2 = {
    nodes: [{
name: "경기스마트카드",
group: 2
},		{
name: "대홍기획",
group: 2
},		{
name: "데크항공",
group: 2
},		{
name: "동교청와피에프브이",
group: 2
},		{
name: "디시네마오브코리아",
group: 2
},		{
name: "롯데건설",
group: 2
},		{
name: "롯데김해개발",
group: 2
},		{
name: "롯데네슬코리아",
group: 2
},		{
name: "롯데닷컴",
group: 2
},		{
name: "롯데디에프글로벌",
group: 2
},		{
name: "롯데디에프리테일",
group: 2
},		{
name: "롯데로지스틱스",
group: 2
},		{
name: "롯데리아",
group: 2
},		{
name: "롯데멤버스",
group: 2
},		{
name: "롯데물산",
group: 2
},		{
name: "롯데미쓰이화학",
group: 2
},		{
name: "롯데백화점마산",
group: 2
},		{
name: "롯데베르살리스엘라스토머스",
group: 2
},		{
name: "롯데상사",
group: 2
},		{
name: "롯데손해보험",
group: 1
},		{
name: "롯데송도쇼핑타운",
group: 2
},		{
name: "롯데쇼핑",
group: 1
},		{
name: "롯데수원역쇼핑타운",
group: 2
},		{
name: "롯데아사히주류",
group: 2
},		{
name: "롯데알미늄",
group: 2
},		{
name: "롯데엠알시",
group: 2
},		{
name: "롯데역사",
group: 2
},		{
name: "롯데인천개발",
group: 2
},		{
name: "롯데인천타운",
group: 2
},		{
name: "롯데자산개발",
group: 2
},		{
name: "롯데자인언츠",
group: 2
},		{
name: "롯데정보통신",
group: 2
},		{
name: "롯데제과",
group: 1
},		{
name: "롯데제이티비",
group: 2
},		{
name: "롯데칠성음료",
group: 1
},		{
name: "롯데카드",
group: 2
},		{
name: "롯데캐피탈",
group: 2
},		{
name: "롯데케미칼",
group: 1
},		{
name: "롯데푸드",
group: 1
},		{
name: "롯데피에스넷",
group: 2
},		{
name: "롯데하이마트",
group: 1
},		{
name: "마곡지구피에프브이",
group: 2
},		{
name: "마이비",
group: 2
},		{
name: "모비쟆미디어",
group: 2
},		{
name: "바이더웨이",
group: 2
},		{
name: "백학음료",
group: 2
},		{
name: "부산롯데호텔",
group: 2
},		{
name: "부산하나로카드",
group: 2
},		{
name: "삼박엘에프티",
group: 2
},		{
name: "씨에스유통",
group: 2
},		{
name: "씨에이치음료",
group: 2
},		{
name: "씨텍",
group: 2
},		{
name: "에치유아이",
group: 2
},		{
name: "에프알엘코리아",
group: 2
},		{
name: "엔씨에프",
group: 2
},		{
name: "엔젤위드",
group: 2
},		{
name: "엠제이에이와인",
group: 2
},		{
name: "엠허브",
group: 2
},		{
name: "우리홈쇼핑",
group: 2
},		{
name: "유니버셜스튜디오코리아리조트개발",
group: 2
},		{
name: "유니버셜스튜디오코리아리조트자산관리",
group: 2
},		{
name: "은평피에프브이",
group: 2
},		{
name: "이비카드",
group: 2
},		{
name: "이지스일호",
group: 2
},		{
name: "인천스마트카드",
group: 2
},		{
name: "장교프로젝트금융투자",
group: 2
},		{
name: "충북소주",
group: 2
},		{
name: "캐논코리아비즈니스솔루션",
group: 2
},		{
name: "케이피켐텍",
group: 2
},		{
name: "코리아세븐",
group: 2
},		{
name: "한국에스티엘",
group: 2
},		{
name: "한국후지필름",
group: 2
},		{
name: "한페이시스",
group: 2
},		{
name: "현대로직스틱스",
group: 2
},		{
name: "현대정보기술",
group: 2
},		{
name: "현대코스코로지스틱스",
group: 2
},		{
name: "호텔롯데",
group: 2
}],
"links": [{
source: 1,
target: 8
}, {
source: 1,
target: 43
}, {
source: 1,
target: 57
}, {
source: 1,
target: 19
}, {
source: 1,
target: 26
}, {
source: 1,
target: 31
}, {
source: 1,
target: 32
}, {
source: 1,
target: 36
}, {
source: 5,
target: 21
}, {
source: 5,
target: 27
}, {
source: 5,
target: 28
}, {
source: 5,
target: 29
}, {
source: 5,
target: 32
}, {
source: 5,
target: 36
}, {
source: 8,
target: 33
}, {
source: 8,
target: 39
}, {
source: 9,
target: 10
}, {
source: 11,
target: 69
}, {
source: 11,
target: 18
}, {
source: 11,
target: 67
}, {
source: 12,
target: 1
}, {
source: 12,
target: 30
}, {
source: 12,
target: 11
}, {
source: 12,
target: 31
}, {
source: 12,
target: 36
}, {
source: 12,
target: 71
}, {
source: 14,
target: 37
}, {
source: 18,
target: 36
}, {
source: 18,
target: 67
}, {
source: 18,
target: 71
}, {
source: 21,
target: 1
}, {
source: 21,
target: 4
}, {
source: 21,
target: 8
}, {
source: 21,
target: 12
}, {
source: 21,
target: 30
}, {
source: 21,
target: 54
}, {
source: 21,
target: 58
}, {
source: 21,
target: 69
}, {
source: 21,
target: 6
}, {
source: 21,
target: 11
}, {
source: 21,
target: 13
}, {
source: 21,
target: 16
}, {
source: 21,
target: 18
}, {
source: 21,
target: 20
}, {
source: 21,
target: 22
}, {
source: 21,
target: 24
}, {
source: 21,
target: 26
}, {
source: 21,
target: 27
}, {
source: 21,
target: 28
}, {
source: 21,
target: 29
}, {
source: 21,
target: 35
}, {
source: 21,
target: 36
}, {
source: 21,
target: 38
}, {
source: 21,
target: 40
}, {
source: 21,
target: 49
}, {
source: 21,
target: 53
}, {
source: 21,
target: 61
}, {
source: 21,
target: 70
}, {
source: 24,
target: 30
}, {
source: 24,
target: 5
}, {
source: 24,
target: 18
}, {
source: 24,
target: 32
}, {
source: 24,
target: 34
}, {
source: 24,
target: 67
}, {
source: 24,
target: 71
}, {
source: 26,
target: 19
}, {
source: 26,
target: 20
}, {
source: 27,
target: 20
}, {
source: 29,
target: 3
}, {
source: 29,
target: 20
}, {
source: 29,
target: 22
}, {
source: 29,
target: 41
}, {
source: 29,
target: 59
}, {
source: 29,
target: 60
}, {
source: 29,
target: 61
}, {
source: 29,
target: 65
}, {
source: 31,
target: 42
}, {
source: 31,
target: 62
}, {
source: 31,
target: 72
}, {
source: 31,
target: 5
}, {
source: 31,
target: 21
}, {
source: 31,
target: 26
}, {
source: 31,
target: 39
}, {
source: 31,
target: 67
}, {
source: 31,
target: 74
}, {
source: 32,
target: 8
}, {
source: 32,
target: 12
}, {
source: 32,
target: 30
}, {
source: 32,
target: 69
}, {
source: 32,
target: 11
}, {
source: 32,
target: 21
}, {
source: 32,
target: 26
}, {
source: 32,
target: 29
}, {
source: 32,
target: 31
}, {
source: 32,
target: 34
}, {
source: 32,
target: 38
}, {
source: 32,
target: 71
}, {
source: 34,
target: 8
}, {
source: 34,
target: 12
}, {
source: 34,
target: 23
}, {
source: 34,
target: 30
}, {
source: 34,
target: 45
}, {
source: 34,
target: 66
}, {
source: 34,
target: 5
}, {
source: 34,
target: 11
}, {
source: 34,
target: 21
}, {
source: 34,
target: 29
}, {
source: 34,
target: 31
}, {
source: 34,
target: 36
}, {
source: 34,
target: 38
}, {
source: 34,
target: 50
}, {
source: 34,
target: 56
}, {
source: 34,
target: 71
}, {
source: 35,
target: 42
}, {
source: 35,
target: 62
}, {
source: 35,
target: 48
}, {
source: 36,
target: 13
}, {
source: 36,
target: 35
}, {
source: 37,
target: 51
}, {
source: 37,
target: 68
}, {
source: 37,
target: 2
}, {
source: 37,
target: 5
}, {
source: 37,
target: 11
}, {
source: 37,
target: 15
}, {
source: 37,
target: 17
}, {
source: 37,
target: 24
}, {
source: 37,
target: 25
}, {
source: 37,
target: 29
}, {
source: 37,
target: 38
}, {
source: 37,
target: 48
}, {
source: 38,
target: 1
}, {
source: 38,
target: 30
}, {
source: 38,
target: 7
}, {
source: 38,
target: 11
}, {
source: 38,
target: 26
}, {
source: 38,
target: 36
}, {
source: 42,
target: 72
}, {
source: 42,
target: 47
}, {
source: 46,
target: 12
}, {
source: 46,
target: 42
}, {
source: 46,
target: 46
}, {
source: 46,
target: 76
}, {
source: 46,
target: 13
}, {
source: 46,
target: 19
}, {
source: 46,
target: 21
}, {
source: 46,
target: 24
}, {
source: 46,
target: 26
}, {
source: 46,
target: 35
}, {
source: 46,
target: 36
}, {
source: 46,
target: 38
}, {
source: 62,
target: 42
}, {
source: 62,
target: 0
}, {
source: 62,
target: 64
}, {
source: 63,
target: 73
}, {
source: 66,
target: 52
}, {
source: 67,
target: 55
}, {
source: 69,
target: 44
}, {
source: 69,
target: 39
}, {
source: 71,
target: 1
}, {
source: 71,
target: 30
}, {
source: 71,
target: 21
}, {
source: 71,
target: 36
}, {
source: 73,
target: 75
}, {
source: 76,
target: 1
}, {
source: 76,
target: 8
}, {
source: 76,
target: 12
}, {
source: 76,
target: 3
}, {
source: 76,
target: 5
}, {
source: 76,
target: 9
}, {
source: 76,
target: 11
}, {
source: 76,
target: 14
}, {
source: 76,
target: 18
}, {
source: 76,
target: 19
}, {
source: 76,
target: 21
}, {
source: 76,
target: 24
}, {
source: 76,
target: 27
}, {
source: 76,
target: 28
}, {
source: 76,
target: 29
}, {
source: 76,
target: 31
}, {
source: 76,
target: 32
}, {
source: 76,
target: 34
}, {
source: 76,
target: 36
}, {
source: 76,
target: 37
}, {
source: 76,
target: 38
}, {
source: 76,
target: 59
}, {
source: 76,
target: 65
}, {
source: 76,
target: 67
}, {
source: 76,
target: 71
}]

};
</script>

</body>
</html>
