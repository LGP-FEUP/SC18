import 'package:erasmus_helper/views/home/home_page.dart';
import 'package:erasmus_helper/views/school/school_page.dart';
import 'package:erasmus_helper/views/social/social_page.dart';

import 'package:flutter/material.dart';

/// Mother widget of all the 3 pages (Home, School, Social), contain the bottom
/// navigation bar and its logic
class AppLayout extends StatefulWidget {
  const AppLayout({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _AppScaffold();
}

class _AppScaffold extends State<AppLayout> {
  int _selectedNavBarPageIndex = 0;

  final navbarPages = [
    const SchoolPage(),
    const HomePage(),
    const SocialPage()
  ];

  void _changeNavBarPage(int index) {
    setState(() {
      _selectedNavBarPageIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Center(
            child: navbarPages[_selectedNavBarPageIndex]
        ),
        bottomNavigationBar: BottomNavigationBar(
          items: const <BottomNavigationBarItem>[
            BottomNavigationBarItem(icon: Icon(Icons.school), label: "School"),
            BottomNavigationBarItem(icon: Icon(Icons.home), label: "Home"),
            BottomNavigationBarItem(icon: Icon(Icons.group), label: "Social")
          ],
          currentIndex: _selectedNavBarPageIndex,
          onTap: _changeNavBarPage,
        )
    );
  }
}
