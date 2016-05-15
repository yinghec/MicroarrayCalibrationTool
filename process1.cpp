#include <iostream>
#include <fstream>
#include <string>
#include <vector>
using namespace std;

//serial, factor, txtname
std::vector<string> helper(std::string line) {
	std::vector<string> v;
	std::string s;
	for (int i = 0; i < line.length(); i++) {
		std::string sub = line.substr(i, 1);
		if (sub == " " || sub == "\t") {
			v.push_back(s);
			s = "";
		} else {
			s += sub;
		}
	}
	v.push_back(s);
	return v;
}

int main(int argc, char* argv[]) {
	string toRead; //calib_0_5.txt
	string toWrite; //Into.txt
	string serial; //1235677
	string factor; //0.5

	if (argc != 5) {
		cout << "usage: " << argv[1] << "<filename>\n";
	} else {
		toRead = argv[1];
		toWrite = argv[2];
		serial = argv[3];
		factor = argv[4];
	}

	ofstream myfile;
	std::string newline;
	std::string line;
	std::vector< string > Result;
	ifstream readfile(toRead);
	myfile.open(toWrite);
	while (!readfile.eof()) {
		std:getline(readfile, line);
		Result = helper(line);
		newline = Result[0] + " " + factor + " " + Result[1] + " " + serial + "\n";
		myfile << newline;
	}
	myfile.close();
	return 0;
}