import 'package:cached_network_image/cached_network_image.dart';
import 'package:erasmus_helper/services/group_service.dart';
import 'package:flutter/material.dart';

class GroupCard extends StatelessWidget {
  final String groupId;

  const GroupCard({Key? key, required this.groupId}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Column(
        children: [
          FutureBuilder(
            future: GroupService.getGroupImage(groupId),
            builder: (context, response) {
              if (response.connectionState == ConnectionState.done) {
                if (response.data != null) {
                  return Expanded(
                    child: CachedNetworkImage(
                      placeholder: (context, url) =>
                          const CircularProgressIndicator(),
                      imageUrl: response.data as String,
                      errorWidget: (context, url, error) => const CircularProgressIndicator(),
                    ),
                  );
                } else if(response.hasError) {
                  // TODO: Load placeholder from local storage
                  return const CircularProgressIndicator();
                }
              }
              return Container();
            },
          ),
          Row(
            children: [
              FutureBuilder(
                future: GroupService.getGroupTitle(groupId),
                builder: (context, response) {
                  if (response.connectionState == ConnectionState.done) {
                    if (response.data != null) {
                      return Text(
                        response.data.toString(),
                        style: const TextStyle(fontSize: 20),
                      );
                    }
                  }
                  return Container();
                },
              )
            ],
          )
        ],
      ),
    );
  }
}
