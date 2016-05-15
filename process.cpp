#include <iostream>
#include <fstream>
#include <string>
#include <vector>
using namespace std;

//serial, factor, txtname
std::vector<string> helper( std::string line) {
	std::vector<string> v;
	std::string s;
	for (int i = 0; i < line.length(); i++) {
		std::string sub = line.substr(i);
		if (sub == " ") {
			v.insert(s);
			s = "";
		}else {
			s += sub;
		}
	}
	return v;
}

int main () {
	ofstream myfile;
	std::string newline;
	std::string line;
	std::vector< string > Result;
	ifstream readfile (".txt");
	myfile.open(".txt");
	while (! readfile.eof()){
		getline (readfile, line);
      	Result = helper(line);
		newline = Result[0]+ " " + "$factor" + " " + Result[1]+ " " +"$serial" + "\n";
		myfile << newline;
	}
	myfile.close();
	return 0;

}