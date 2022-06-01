import 'package:erasmus_helper/views/app_drawer.dart';
import 'package:erasmus_helper/views/guides/guides_page.dart';
import 'package:erasmus_helper/views/home/home_page.dart';
import 'package:erasmus_helper/views/profile/profile_screen.dart';
import 'package:erasmus_helper/views/social/social_page.dart';
import 'package:flutter/material.dart';

class AppLayout extends StatefulWidget {
  final Widget body;
  final PreferredSizeWidget? bottom;
  final String title;
  final bool activateBackButton;
  final FloatingActionButton? floatingButton;
  final bool showBottomBar;

  const AppLayout({Key? key,
    required this.body,
    this.title = "Erasmus Helper",
    this.bottom,
    this.floatingButton,
    this.activateBackButton = false,
    this.showBottomBar = true})
      : super(key: key);

  @override
  State<StatefulWidget> createState() => _AppScaffold();
}

class _AppScaffold extends State<AppLayout> {
  int _selectedNavBarPageIndex = 0;
  late Widget _currentBody;

  final navbarPages = [HomePage(), const GuidesPage(), const SocialPage()];
  void _changeNavBarPage(int index) {
    setState(() {
      _selectedNavBarPageIndex = index;
      _currentBody = navbarPages[_selectedNavBarPageIndex];
    });
  }

  @override
  void initState() {
    super.initState();
    _currentBody = widget.body;
  }

@override
Widget build(BuildContext context) {
  Widget? drawer;
  if (!widget.activateBackButton) {
    drawer = const AppDrawer();
  }

  return SafeArea(
    child: Scaffold(
      floatingActionButton: widget.floatingButton,
      body: _currentBody,
      drawer: drawer,
      appBar: AppBar(
        automaticallyImplyLeading: true,
        foregroundColor: Theme
            .of(context)
            .primaryColor,
        backgroundColor: Colors.white,
        title: Text(
          widget.title,
          style: const TextStyle(fontSize: 23, fontWeight: FontWeight.w600),
        ),
        bottom: widget.bottom,
        actions: [
          // TODO : change with avatar of the account
          GestureDetector(
              child: const CircleAvatar(
                backgroundImage: AssetImage("assets/avatar.png"),
              ),
              onTap: () =>
                  Navigator.push(
                      context, MaterialPageRoute(builder: (context) => const ProfileScreen()))),
          // TODO : add notification system
          IconButton(onPressed: () {}, icon: const Icon(Icons.notifications))
        ],
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(icon: Icon(Icons.home), label: "Home"),
          BottomNavigationBarItem(icon: Icon(Icons.school), label: "Guides"),
          BottomNavigationBarItem(icon: Icon(Icons.group), label: "Social")
        ],
        showSelectedLabels: false,
        showUnselectedLabels: false,
        selectedIconTheme: const IconThemeData(size: 28),
        currentIndex: _selectedNavBarPageIndex,
        onTap: _changeNavBarPage,
      ),
    ),
  );
}}
