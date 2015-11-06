//Utils

function clamp(x, min, max)
{
	var ret = x;
	if(x < min){ret = min;}
	else if (x > max){ret = max;}
	return ret;
}