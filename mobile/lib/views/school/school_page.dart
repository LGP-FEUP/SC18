import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:erasmus_helper/views/school/administration_tab.dart';
import 'package:erasmus_helper/views/school/university_tab.dart';
import 'package:flutter/material.dart';

// TODO : replace this page with the good content
class SchoolPage extends StatelessWidget {
  const SchoolPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const DefaultTabController(
        length: 2,
        child: AppTopBar(
          body: TabBarView(
            children: [
              AdministrationTab(),
              UniversityTab()
            ],
          ),
          title: "School",
          bottom: TabBar(
              tabs: [
                Tab(text: "Administration",),
                Tab(text: "University",)
              ]
          ),
        )
    );
  }
}